
@extends('layouts.default')
@section('content')

    <?php $userCount=0; $totalSeats=0;?>

    <div class="row"  style="padding-top:25px;">
        <div class="col-md-12" style="">
            @if(! empty(Session::get('errormsg')))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get('errormsg')}}
                </div>
            @endif
        </div>
    </div>
    <div class="row" style="padding-top:10px;">
        <div class="col-md-4" >            
            <h3>Your Courses</h3>
            <div class="row" style="padding-top:15px;padding-right:15px;">
                    <div class="col-md-7" style="">
                        <strong>Course</strong>
                    </div>
                    <div class="col-md-2 text-center">
                        <strong>Seats</strong>
                    </div>
                    <div class="col-md-3 " style="text-align: right;padding-left:5px;">
                        <strong>Price</strong>
                    </div>
                    
                </div>
            @foreach ($cart as $cartDetail)
                <div class="row" style="padding-top:15px;padding-right:15px;">
                    <div class="col-md-7" style="">
                        <strong>{{$cartDetail['name']}}</strong>
                    </div>
                    <div class="col-md-2 text-center">
                        {{$cartDetail['qty']}}
                    </div>
                    <div class="col-md-3 " style="text-align: right;padding-left:5px;">


                        @if($cartDetail['price'] <> 0)
                            <div class="usdPrice">&#36;{{$cartDetail['price']}}</div>
                        @endif
                    </div>
                    
                </div>
            @endforeach
            <div class="row"  style="border-top:1px solid #cccccc">
            </div>
            <div class="row spacer" style="padding-right:15px">
                <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Subtotal:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;padding-left:5px;">


                    <div class="usdPrice">&#36;{{$cartTotal}}</div>
                </div>

            </div>
            <div class="row spacer" style="padding-right:15px">
                
                 <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Discount:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;">
                   
                    <div class="usdPrice">-&#36;{{$discount}}</div>
                </div>

            </div>
            <div class="row spacer" style="padding-right:15px">
                <div class="col-md-3" style="">

                </div>
                <div class="col-md-6 text-right">
                <strong>Grand Total:</strong>
                </div>
                <div class="col-md-3" style="text-align:right;padding-left:5px;">
                    <?php
                    $z_total =($cartTotal - $discount);
                    $z_total =number_format($z_total, 2, '.', '');
                    ?>

                    <div class="usdPrice">&#36;{{$z_total}}</div>
                </div>

            </div>
            
            
        </div>
        <div class="col-md-8" style="border-left:#cccccc 1px solid;">

            @foreach($cart as $cartDetails)
                <div class="row spacer" style="padding-top:20px;">
                    <div class="col-md-12">
                    <strong>{{$cartDetails->name}}</strong><br>
                    {!! $cartDetails->options->course_details !!}
                        </div>
                </div>
            <?php $totalSeats = $totalSeats+$cartDetails['qty'];?>

                @foreach($cartDetails->options->assignTo as $key => $assignTo)
                    <div class="row spacer" style="border-bottom:#cccccc 1px solid; padding-bottom: 20px;">

                        <div class="col-md-12"><strong>Seat {{$key+1}}</strong></div>

                        @if($assignTo['assign'] <> '')
                            <?php $userCount = $userCount+1;?>

                            <div class="col-md-12">
                                @if($assignTo['assign'] == 'self')
                                    <p>This course will be assigned to:<br>
                                        {{$userInfo->first_name}} {{$userInfo->last_name}} ({{$userInfo->username}})</p>
                                @elseif($assignTo['assign'] == 'existing')
                                    <p>
                                        This course will be assigned to:<br>
                                        {{$assignTo['firstname']}} {{$assignTo['lastname']}} ({{$assignTo['litmosusername']}})

                                    </p>
                                @elseif($assignTo['assign'] == 'new')
                                    <p>
                                        This course will be assigned to a new user:<br>
                                        {{$assignTo['firstname']}} {{$assignTo['lastname']}} ({{$assignTo['litmosusername']}})<br>
                                        Company: {{$assignTo['company']}} <br>
                                        Title: {{$assignTo['title']}}<br>
                                        Address: {{$assignTo['street']}} {{$assignTo['city']}}, {{$assignTo['state']}} {{$assignTo['zip']}}<br>
                                        Work Phone: {{$assignTo['workphone']}}<br>
                                        Country: {{$assignTo['country']}}<br>
                                        Timezone: {{$assignTo['timezone']}}

                                    </p>
                                @endif
                            </div>
                            @if($key==0)
                                <div class="col-md-3">
                                    {{ Form::open(['url' => env('APP_URL').'/assign-course']) }}
                                    {{Form::hidden('rowid',$cartDetails->rowid)}}
                                    {{Form::hidden('arraycnt',$key)}}
                                    {{Form::hidden('litmos_id',$userInfo->litmos_id)}}
                                    {{Form::hidden('first_name',$userInfo->first_name)}}
                                    {{Form::hidden('last_name',$userInfo->last_name)}}
                                    {{Form::hidden('username',$userInfo->username)}}
                                    {{ Form::submit('Assign To Me',['name'=>'assign','class'=>'btn btn-primary btn-lg']) }}
                                    {{ Form::close() }}
                                </div>
                            @endif
                            <div class="col-md-3">
                                {{ Form::open(['url' => env('APP_URL').'/assign-course']) }}
                                {{Form::hidden('rowid',$cartDetails->rowid)}}
                                {{Form::hidden('arraycnt',$key)}}
                                {{Form::hidden('show',0)}}
                                {{ Form::submit('Assign To Other',['name'=>'assign','class'=>'btn btn-primary btn-lg']) }}
                                {{ Form::close() }}
                            </div>
                        @else
                            @if($key==0)
                                <div class="col-md-3">
                                    {{ Form::open(['url' => env('APP_URL').'/assign-course']) }}
                                    {{Form::hidden('rowid',$cartDetails->rowid)}}
                                    {{Form::hidden('arraycnt',$key)}}
                                    {{Form::hidden('litmos_id',$userInfo->litmos_id)}}
                                    {{Form::hidden('first_name',$userInfo->first_name)}}
                                    {{Form::hidden('last_name',$userInfo->last_name)}}
                                    {{Form::hidden('username',$userInfo->username)}}
                                    {{ Form::submit('Assign To Me',['name'=>'assign','class'=>'btn btn-primary btn-lg']) }}
                                    {{ Form::close() }}
                                </div>
                            @endif
                            <div class="col-md-3">
                                {{ Form::open(['url' => env('APP_URL').'/assign-course']) }}
                                {{Form::hidden('rowid',$cartDetails->rowid)}}
                                {{Form::hidden('arraycnt',$key)}}
                                {{Form::hidden('show',0)}}
                                {{ Form::submit('Assign To Other',['name'=>'assign','class'=>'btn btn-primary btn-lg']) }}
                                {{ Form::close() }}
                            </div>
                        @endif



                    </div>
                @endforeach
            @endforeach
        </div>
        <div class="spacer col-md-12 text-right">

            <a href="/checkout-step-2" class="btn btn-primary">Continue to Billing</a>

        </div>
    </div>


@stop
@section('scripts')
    <script>

    </script>


@stop

