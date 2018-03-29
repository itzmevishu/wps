<?php
    use App\Models\PromoCourse;
    use App\Models\Catalog;
?>

@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    <a href="/admin">Return to Admin</a>
    <h3>Promo Codes</h3>
    <div class="row spacer ">
        <div class="col-md-6 text-left">
            <ul class="nav nav-pills">
                <li role="presentation" @if(isset($input['tab']) && $input['tab'] == 'all') class="active" @endif><a href="/admin/promos?page=1&tab=all">All</a></li>
                <li role="presentation" @if(isset($input['tab']) && $input['tab'] == 'active') class="active" @endif><a href="/admin/promos?page=1&tab=active">Active</a></li>
                <li role="presentation" @if(isset($input['tab']) && $input['tab'] == 'inactive') class="active" @endif><a href="/admin/promos?page=1&tab=inactive">Inactive</a></li>
            </ul>
        </div>
        <div class="col-md-6 text-right">
            {{ Form::open(['url' =>env('APP_URL').'/admin/promos/search?tab=all']) }}
            <div class="col-md-8 text-right">

                {{Form::text('promo_search','',['class'=>'form-control col-md-4','autocomplete'=>'off','tabindex'=>1,'placeholder'=>'Search by Promo Code...'])}}
                <div class="errors">{{$errors->first('promo_search')}}</div>
            </div>
            <div class="col-md-4 text-right" style="padding-right:0px;">
                {{ Form::submit('Search Promos',['class'=>'btn btn-primary','style'=>"margin-right:0px;"]) }}

            </div>
            {{ Form::close() }}
        </div>

    </div>

    <div class="col-md-12 spacer">

        <div class="row userGridRowHeader">
            <div class="col-md-2 userGridColHeader" >Promo Code</div>
            <div class="col-md-2 userGridColHeader" >Description</div>
            <div class="col-md-2 userGridColHeader" >Start Date</div>
            <div class="col-md-2 userGridColHeader" >End Date</div>
            <div class="col-md-1 userGridColHeader" >Stackable</div>
            <div class="col-md-1 userGridColHeader" >Use</div>
            <div class="col-md-1 userGridColHeader" >&nbsp;</div>

        </div>

        @foreach ($promos as $promo)
            <div class="row altBG">
                <div class="col-md-2 userGridColItem">{{$promo->promo_code}}</div>
                <div class="col-md-2 userGridColItem">{{$promo->promo_desc}} {{$promo->promo_apply_to}}</div>
                @if($promo->promo_no_expiry)
                    <div class="col-md-2 userGridColItem">{{$promo->promo_start_dt}}</div>
                    <div class="col-md-2 userGridColItem">-</div>
                @else
                    <div class="col-md-2 userGridColItem">{{$promo->promo_start_dt}}</div>
                    <div class="col-md-2 userGridColItem">{{$promo->promo_end_dt}}</div>
                @endif
                @if($promo->promo_stackable)
                    <div class="col-md-1 userGridColItem">Yes</div>
                @else
                    <div class="col-md-1 userGridColItem">No</div>
                @endif
                @if($promo->promo_single_use)
                    <div class="col-md-1 userGridColItem">Once</div>
                @else
                    <div class="col-md-1 userGridColItem">No Limit</div>
                @endif

                @if($promo->promo_enable)
                    <div class="col-md-1 userGridColItem"><a href="/admin/promos/disable/{{$promo->id}}">disable</a></div>
                @else
                    <div class="col-md-1 userGridColItem"><a href="/admin/promos/enable/{{$promo->id}}">enable</a></div>
                @endif

                    <div class="col-md-1 userGridColItem"><a href="/admin/promos/delete/{{$promo->id}}">delete</a></div>
                    <?php
                        $getPromoCount = DB::table('promos_used')->where('promo_id',$promo->id)->count();

                    ?>
                    <div class="col-md-12" style="padding-bottom: 5px;font-style: italic;">
                    This promo has been used <strong>{{$getPromoCount}}</strong> times.
                    </div>
                @if($promo->promo_type_id == 2 || $promo->promo_type_id == 3)
                    <?php
                        $getCourses = DB::table('catalog')->select('name')->join('promos_course','catalog.id','=','promos_course.course_id')->where('promo_id',$promo->id)->get();

                    ?>

                <div class="col-md-12" style="padding-bottom: 5px;font-style: italic;">
                    Courses @if($promo->promo_all_products_req) (All required) @endif @if(!$promo->promo_all_products_req) (At least ONE required) @endif:
                    @foreach($getCourses as $course)
                        / {{$course->name}} &nbsp;&nbsp;
                    @endforeach
                </div>
                @endif
                @if($promo->promo_fam)
                <div class="col-md-12" style="padding-bottom: 5px;font-style: italic;">
                    Free FAM Course: Free course eligible to Learners w/ serial# & Activation Code
                </div>
                @endif
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-8 text-left" style="padding-left: 0px;">
                @if(isset($input['tab']))
                    {{ $promos->appends(['tab' => $input['tab']])->links() }}
                @else
                    {{ $promos->appends(['tab' => 'active'])->links() }}
                @endif
            </div>
            <div class="col-md-2 text-right" style="padding-right: 0px; margin: 20px 0px;">
                @if($search == 'yes')
                    <a href="/admin/users" class="btn btn-secondary" style="margin: 0px;">Show All</a>
                @endif
            </div>
            <div class="col-md-2 text-right" style="padding-right: 0px; margin: 20px 0px;">
                <a href="/admin/promos/new" class="btn btn-primary" style="margin: 0px;">Add Promo</a>
            </div>
        </div>


        </div>


    </div>
</div>






@stop
@section('scripts')
    <script>
        $(document).ready(function(){
            $( ".altBG:even" ).css( "background-color", "#ffffff" );
            $( ".altBG:odd" ).css( "background-color", "#d8cfc6" );
        });
    </script>
@stop

