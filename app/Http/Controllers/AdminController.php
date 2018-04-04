<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Country;
use App\Models\OrderLog;
use App\Models\PromoTypes;
use App\Models\User;
use App\Models\Catalog;
use App\Models\Promo;
use App\Models\PromoCourse;
use App\Models\PromoType;
use App\Models\OrderDump;
use App\Models\SerialNumbers;
use App\Models\Tokens;
use App\Models\TokenUsers;
use App\Models\CourseSession;
use App\Http\Controllers\Controller;
use App\Functions\litmosAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use View;
use Form;
use Input;
use Session;
use Storage;
use Maatwebsite\Excel\Facades\Excel;



class AdminController extends Controller {

   public function nwfaSSO($username)
    {
        $getYMUsername = $username;

        //$checkLMSUser = litmosAPI::apiUserExists($getYMUsername);

        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.litmos.com/v1.svc/']);

        $createRequest =$client->request('GET','users/'.$getYMUsername,
            [
                'query' =>
                    [
                        'apikey' => 'A4E14F04-85D0-4331-92DC-FD0E484721ED',
                        'source' => 'nwfa'
                    ],
                'body' => '',
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false
            ]);


        $requestCode = $createRequest->getStatusCode();

        //dd($requestCode);

        if($requestCode == 200){
            $getUserInfo=json_decode($createRequest->getBody());

            //return $getUserInfo->LoginKey;
            return Redirect::to($getUserInfo->LoginKey);

        }
    }


   public function adminHome()
    {
        return View::make('admin.home');

    }

    public function showPhotoForm($course_id = null){

        $courses = \App\Models\Catalog::courses();
        return View::make('admin.photos.upload-form')
                    ->with(compact(array('courses', 'course_id')));
    }

    public function uploadPhoto(Request $request){


        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
            'course' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::to('admin/photos')->withInput()->withErrors($validator);
        }

        $image = $request->file('image');
        $course_id = $request->input('course');
        if ($image->isValid()) {

            $destination_file = $request->input('course').'.'.$image->getClientOriginalExtension();
            $destinationPath = $destination_file;
            //$res = $image->move($destinationPath, $destination_file);

            Storage::disk('public')->put(
                $destinationPath,
                file_get_contents($image->getRealPath()),
                'public'
            );

            $url = Storage::disk('public')->url($destinationPath);


            $catalog = Catalog::find($course_id);
            $catalog->image = env('APP_URL').$url;
            $catalog->save();


            Session::flash('success', 'Upload successfully');
            return Redirect::to('admin/photos');
        }
        else {
            Session::flash('error', 'uploaded file is not valid');
            return Redirect::to('admin/photos');
        }

    }

    public function searchUsers(Request $request){
        $input = $request->all();

        $rules=[
            'user_search'=>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/admin/users')->withInput()->withErrors($validator);

        }

        $findUser = User::where('username','LIKE','%'.$input['user_search'].'%')->paginate(25);

        //return $findUser;

        return View::make('admin.users.show-users',['users'=>$findUser,'search'=>'yes']);

    }

    public function showUsers(){

        $users = User::paginate(25);

        return View::make('admin.users.show-users',['users'=>$users,'search'=>'no']);
    }

    public function showTokens(){

        $tokens = TokenUsers::select('serial_number','activation_code','lms_title','first_name','last_name','company_name','ecomm_user_tokens.created_at','ecomm_user_tokens.id')->join('ecomm_users','ecomm_users.id','=','ecomm_user_tokens.user_id')
        ->join('ecomm_catalog','ecomm_catalog.id','=','ecomm_user_tokens.catalog_id')->paginate(10);

        return View::make('admin.tokens.show-tokens',['tokens'=>$tokens,'token_search'=>'']);
    }

    public function searchTokens(Request $request){
        $input = $request->all();

        $rules=[
            'token_search'=>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::back()->withInput()->withErrors($validator);

        }

        $serial_number = $input['token_search'];
        $serial_number = str_replace (" ", "", $serial_number);
        $serial_number = str_replace ("-", "", $serial_number);
        $serial_number = strtoupper($serial_number);
        $serial_number_hash = SHA1($serial_number);
        $isSerialNumber = SerialNumbers::where('HASHED_VALUE',$serial_number_hash)->first();

        if($isSerialNumber <> ''){


            //$findPromo = Promo::where('promo_code','LIKE','%'.$input['promo_search'].'%')->paginate(25);

             $tokens = TokenUsers::select('serial_number','serial_id','token_count','activation_code','lms_title','first_name','last_name','company_name','ecomm_user_tokens.created_at','ecomm_user_tokens.id')->join('ecomm_users','ecomm_users.id','=','ecomm_user_tokens.user_id')
            ->join('ecomm_catalog','ecomm_catalog.id','=','ecomm_user_tokens.catalog_id')
            ->join('ecomm_unitSerial','ecomm_unitSerial.id','=','serial_id')
            ->where('serial_id','=',$isSerialNumber->id)->paginate(10);

            //return $tokens;
            return View::make('admin.tokens.show-tokens',['tokens'=>$tokens,'token_search'=>$input['token_search']]);

        }else{
            return View::make('admin.tokens.show-tokens',['tokens'=>'','token_search'=>$input['token_search']]);
        }

    }

    public function updateTokens(Request $request){
        $input = $request->all();
       //return $input;

        $updateToken= SerialNumbers::find($input['serial_id']);
        $updateToken->token_count=$input['token_count'];
        $updateToken->save();

        Session::flash('successmsg', 'Token count has been updated.');
        return Redirect('/admin/tokens');

    }

    public function makeAdmin($id){

        $users = User::find($id);
        $users->site_admin = 1;
        $users->save();

        return Redirect::back();
    }

    public function removeAdmin($id){

        $users = User::find($id);
        $users->site_admin = 0;
        $users->save();

        return Redirect::back();
    }


    public function searchPromo(Request $request){
        $input = $request->all();

        $rules=[
            'promo_search'=>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::back()->withInput()->withErrors($validator);

        }

        $findPromo = Promo::where('promo_code','LIKE','%'.$input['promo_search'].'%')->paginate(25);

        //return $findUser;

        return View::make('admin.promos.show-promos',['promos'=>$findPromo,'search'=>'yes','input'=>$input]);

    }

    public function showPromos(Request $request){
        $input = $request->all();

        if(isset($input['tab']) && $input['tab'] == 'active'){
            $getPromos = Promo::where('promo_enable',1)->where('promo_active',1)->paginate(25);
        }elseif(isset($input['tab']) && $input['tab'] == 'inactive'){
            $getPromos = Promo::where('promo_enable',0)->where('promo_active',1)->paginate(25);
        }else{
            $getPromos = Promo::where('promo_active',1)->paginate(25);
        }


        return View::make('admin.promos.show-promos',['promos'=>$getPromos,'input'=>$input,'search'=>'no']);
    }

    public function showPromForm(){
        //get promotypes
        $getPromoTypes = PromoType::lists('promo_type_desc','id');
        $getCourses = Catalog::courses();


        return View::make('admin.promos.promo-form',['getPromoTypes'=>$getPromoTypes,'courseList'=>$getCourses,'search'=>'no']);
    }

    public function deletePromo($id){
        //return $id;

        $promo=Promo::find($id);
        $promo->promo_active = 0;
        $promo->save();

        return Redirect::to('/admin/promos?tab=active');
    }

    public function disablePromo($id){
        //return $id;

        $promo=Promo::find($id);
        $promo->promo_enable = 0;
        $promo->save();

        return Redirect::to('/admin/promos?tab=active');
    }

    public function enablePromo($id){
        //return $id;

        $promo=Promo::find($id);
        $promo->promo_enable = 1;
        $promo->save();

        return Redirect::to('/admin/promos?tab=inactive');
    }

    public function addPromo(Request $request){
        $input = $request->all();

        $rules=[
            'promo_code'=>'required',
            'promo_type'=>'required',
            'promo_dollar_off'=>'required_if:promo_amount_type,dollar|numeric',
            'promo_percent_off'=>'required_if:promo_amount_type,percent|numeric',
            'promo_amount_type'=>'required',
            'promo_apply_to'=>'required_with_all:promo_amount_type,dollar,required_if:promo_type,2,required_if:promo_type,3',
            'promo_start_dt'=>'required',
            'promo_end_dt'=>'required_unless:promo_no_expiry,yes',
            'product_list'=>'required_if:promo_type,2|required_if:promo_type,3'

        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return Redirect::to('/admin/promos/new')->withInput()->withErrors($validator);

            //var_dump($input);

        }

        //return;

        $promoDesc = '';
        $promoSingleUse = '';
        $promoStackable = '';
        $promoNoExpire = '';
        $promoAllProductsReq = '';
        $promoFAM = '';
        $promoQty='';

        if($input['promo_amount_type'] == 'dollar'){
            $promoDesc ='$'.$input['promo_dollar_off'].' Off';
            $dollarOffFlag = 1;
            $percentOffFlag = 0;
            $promoAmount = $input['promo_dollar_off'];
        }else{
            $promoDesc =($input['promo_percent_off']).'% Off';
            $dollarOffFlag = 0;
            $percentOffFlag = 1;
            $promoAmount = $input['promo_percent_off'];
        }

        if(isset($input['promo_per_customer'])){
            $promoSingleUse = true;
        }else{
            $promoSingleUse = false;
        }

        if(isset($input['promo_stackable'])){
            $promoStackable = true;
        }else{
            $promoStackable = false;
        }

        if(isset($input['promo_no_expiry'])){
            $promoNoExpire = true;
        }else{
            $promoNoExpire = false;
        }

        if(isset($input['promo_list_all_req'])){
            $promoAllProductsReq = true;
        }else{
            $promoAllProductsReq = false;
        }

        if(isset($input['promo_fam'])){
            $promoFAM = true;
        }else{
            $promoFAM = false;
        }

        if($input['promo_qty'] != ''){
            $promoQty = $input['promo_qty'];
        }


        $inputPromo = new Promo();
        $inputPromo ->promo_code = $input['promo_code'];
        $inputPromo ->promo_desc = $promoDesc;
        $inputPromo ->promo_single_use = $promoSingleUse;
        $inputPromo ->promo_dollar_off = $dollarOffFlag;
        $inputPromo ->promo_percent_off = $percentOffFlag;
        $inputPromo ->promo_stackable = $promoStackable;
        $inputPromo ->promo_fam = $promoFAM;
        $inputPromo ->promo_qty=$promoQty;

        if(isset($input['promo_apply_to']) && $input['promo_apply_to']  != '') {
            $inputPromo->promo_apply_to = $input['promo_apply_to'];
        }else{
            $inputPromo->promo_apply_to = 'cart';
        }
        $inputPromo ->promo_type_id = $input['promo_type'];

        if(isset($input['promo_start_dt'])) {
            $inputPromo->promo_start_dt = date('Y-m-d', strtotime($input['promo_start_dt']));
        }
        if(isset($input['promo_end_dt'])) {
            $inputPromo->promo_end_dt = date('Y-m-d', strtotime($input['promo_end_dt']));
        }

        $inputPromo ->promo_no_expiry = $promoNoExpire;
        $inputPromo ->promo_active = true;
        $inputPromo ->promo_enable = true;
        $inputPromo ->promo_amount = $promoAmount;
        $inputPromo ->promo_all_products_req = $promoAllProductsReq;
        $inputPromo->save();

        //return $inputPromo->id;

        foreach($input['product_list'] as $course){
            $inputPromoLU = new PromoCourse();
            $inputPromoLU->promo_id = $inputPromo->id;
            $inputPromoLU->course_id = $course;
            $inputPromoLU->save();
        }


        return Redirect::to('/admin/promos?tab=all');
    }

    public function viewCatalog()
    {

        $getProducts = Catalog::paginate(25);

        return View::make('admin.catalog.show-catalog',['products'=>$getProducts]);
    }

    public function updateCatalog()
    {

        $limit = 500;
        $start = 0;
        $active_courses = array();
        while($limit > 0){

            $getCourses = litmosAPI::getUserCourses($limit,$start);

            if(!is_array($getCourses) && empty($getCourses)){
                Session::flash('error', 'Catalog refreshed failed');
                return Redirect::to('/admin/catalog');
            }

            foreach($getCourses as $course) {

                $checkProduct = Catalog::where('course_id',$course->Id)->first();

                # Storing Litmos API data as per new columns created.
                # Columns are associated with Litmos result fields
                if($checkProduct){
                    $item = Catalog::find($checkProduct['id']);
                }else{
                    $item = new Catalog;
                    $item->image = 'http://via.placeholder.com/200x200';
                }

                $item->course_id = $course->Id;
                $item->code = $course->Code;
                $item->name = $course->Name;
                $item->for_sale = $course->ForSale;
                $item->original_id = $course->OriginalId;
                $item->description = $course->Description;
                $item->ecommerce_short_description = $course->EcommerceShortDescription;
                $item->ecommerce_long_description = $course->EcommerceLongDescription;
                $item->price = $course->Price;
                $item->access_till_date = $course->AccessTillDate;
                $item->course_code_for_bulk_import = $course->CourseCodeForBulkImport;

                if($course->ForSale && $course->Active){
                    $item->active = $course->Active;
                }else{
                    $item->active = 0;
                }

                $item->save();

                $active_courses[] = $course->Id;
            }

            if(count($getCourses) > 0){
                $start = $start + count($getCourses);
            }else{
                $limit = 0;
            }

        }


        $allCourses = $titles = DB::table('catalog')->pluck('course_id');
        $inactive_course = array_diff($allCourses, $active_courses);
        DB::table('catalog')->whereIn('course_id', $inactive_course)->update(array('litmos_deleted' => true));

        CourseSession::saveSessions();

        Session::flash('success', 'Catalog refreshed!');
        return Redirect::to('/admin/catalog');

        //return View::make('admin.catalog-complete');
    }

    public function dataDump()
    {
        return View::make('admin.data-dump');
    }

    public function getDataDump(Request $request){
        $input = $request->all();



        //return $endRange;
        $query = \App\Models\OrderLog::orderBy('id', 'desc')
                                        ->select('user_name as Name', 'user_email as Email','order_payment_id as PaymentType','order_total as Amount', 'order_date as OrderDate', 'course_name as CourseName');

        if(!empty($input['from']) && !empty($input['to'])){
            $startRange =  date('Y-m-d 00:00:00',strtotime($input['from']));
            $endRange =  date('Y-m-d 23:59:59',strtotime($input['to']));

            $query->where('order_date', '>=',$startRange);
            $query->where('order_date','<=',$endRange);

        }
        if($input['report_type'] == 'check'){
            $query->where('order_payment_id','=',$input['report_type']);
        }if($input['report_type'] == 'card'){
            $query->where('order_payment_id','<>','check');
        }

        $orders = $query->get();

        Excel::create('All_Orders', function($excel) use($orders) {

            $excel->sheet('Orders', function($sheet) use($orders) {

                $sheet->fromModel($orders);

            });

        })->export('csv');
    }

    public function storePurchaseOrder(Request $request){
        $input = $request->all();
        $result = \App\Models\OrderLog::storePurchaseOrder();
        return $result;

    }

     public function categoryHome()
    {
        $sql = 'select root.name  as root_name, down1.name as down1_name, down2.name as down2_name, down2.id as down2_id
                      from categories as root
                    left outer join categories as down1
                        on down1.parent_id = root.id
                    left outer join categories as down2
                        on down2.parent_id = down1.id
                     where root.parent_id is null
                    order 
                        by root.id 
                         , down1_name 
                         , down2_name';
        $result = DB::select($sql);


        $categories = $subItems = array();
        for ($i = 0; $i < count($result); $i++) {
            if(in_array($result[$i]->down2_name, $subItems) === false){
                array_push($subItems, $result[$i]->down2_name);
                $categories[$result[$i]->root_name][$result[$i]->down1_name][] = array("id" => $result[$i]->down2_id, "name" => $result[$i]->down2_name);
            }
        }

     return View::make('admin.category.home')
                 ->with('categories', $categories);
    }


    public function viewSessions(){

        $future_sessions = CourseSession::orderBy('name')->paginate(10);
        return View::make('admin.sessions.show-sessions',['sessions'=>$future_sessions]);
    }

    public function resetApp(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_details')->truncate();
        DB::table('orders')->truncate();
        DB::table('addresses')->truncate();
        DB::table('bogos')->truncate();

        DB::table('course_assign')->truncate();
        DB::table('course_sessions')->truncate();
        DB::table('course_modules')->truncate();
        DB::table('catalog')->truncate();

        DB::table('category_courses')->truncate();
        DB::table('categories')->truncate();
        DB::table('cheque_payments')->truncate();

        DB::table('profile_field_values')->truncate();
        DB::table('profiles')->truncate();

        DB::table('promos_course')->truncate();
        DB::table('promos_used')->truncate();
        DB::table('promos')->truncate();

        DB::table('users')->where('site_admin', '=', 0)->delete();
        DB::table('users')->where('site_admin', '=', 1)->update(['profile_id' => 0]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return "Application reset successfully";
    }

}
