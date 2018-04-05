<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use Validator;

use URL;

use Session;

use Redirect;

use Illuminate\Support\Facades\Input;

/** All Paypal Details class **/

use PayPal\Rest\ApiContext;

use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;

use PayPal\Api\Details;

use PayPal\Api\Item;

use PayPal\Api\ItemList;

use PayPal\Api\Payer;

use PayPal\Api\Payment;

use PayPal\Api\RedirectUrls;

use PayPal\Api\ExecutePayment;

use PayPal\Api\PaymentExecution;

use PayPal\Api\Transaction;

use Auth;
use Cart;


class AddMoneyController extends HomeController

{

    private $_api_context;
    private $user;
    private $cart;
    private $cartTotal;
    private $cartCount;
    private $discount;

    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
        $this->user = Auth::user();

        /*
         * Cart variables
         */
        $this->cart = Cart::instance('shopping')->content();
        $this->cartTotal = Cart::instance('shopping')->total();
        $this->cartCount = Cart::instance('shopping')->count();
        $promo_discount = Cart::instance('promo')->total();
        $bogo_count = Cart::instance('bogo')->total();
        $this->discount = $promo_discount + $bogo_count;
        $this->cartTotal = $this->cartTotal - $this->discount;
        /** setup PayPal api context **/

        $paypal_conf = \Config::get('paypal');

        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));

        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    private function formatAmount($number){
        return number_format($number, 2, '.', '');
    }


    /**

     * Show the application paywith paypalpage.

     *

     * @return \Illuminate\Http\Response

     */

    public function payWithPaypal()

    {

        return view('paywithpaypal');

    }

    /**

     * Store a details of payment with paypal.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function postPaymentWithpaypal(Request $request)

    {


        $this->cartTotal = $this->formatAmount($this->cartTotal);
        $this->discount = $this->formatAmount($this->discount);

        $items_count = Cart::instance('shopping')->count();


        $payer = new Payer();

        $payer->setPaymentMethod('paypal');
        $items = array();
        foreach ($this->cart as $row){

            $item = new Item();

            $item->setName($row->name)

            ->setCurrency('USD')

                ->setQuantity($row->qty)

                ->setPrice($row->price); /** unit price **/

            $items[] = $item;
        }
        $discount = $this->discount;
        $item3 = new Item();
        $item3->setName('Discount')
            ->setDescription('Discount')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice("-$discount");
        $items[] = $item3;

        $item_list = new ItemList();

        $item_list->setItems($items);

        $amount = new Amount();

        $amount->setCurrency('USD')

            ->setTotal($this->cartTotal);

        $transaction = new Transaction();

        $transaction->setAmount($amount)

            ->setItemList($item_list)

            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();

        $redirect_urls->setReturnUrl(URL::route('payment.status')) /** Specify return URL **/

            ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();

        $payment->setIntent('Sale')

            ->setPayer($payer)

            ->setRedirectUrls($redirect_urls)

            ->setTransactions(array($transaction));

            /** dd($payment->create($this->_api_context));exit; **/

        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                \Session::put('error','Connection timeout');

                return Redirect::route('show.cart');

                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/

                /** $err_data = json_decode($ex->getData(), true); **/

                /** exit; **/

            } else {

                \Session::put('error','Some error occur, sorry for inconvenient');

                return Redirect::route('show.cart');

                /** die('Some error occur, sorry for inconvenient'); **/

            }

        }

        foreach($payment->getLinks() as $link) {

            if($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();

                break;

            }

        }

        /** add payment ID to session **/

        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {

            /** redirect to paypal **/

            return Redirect::away($redirect_url);

        }

        Session::put('error','Unknown error occurred');

        return Redirect::route('show.cart');

    }



  }