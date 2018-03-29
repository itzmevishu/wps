
@extends('layouts.default')
@section('content')

<div class="row" style="padding-top:25px;">
    <a href="/admin">Return to Admin</a>
    <h3>WPS Learning Store Accounts</h3>

    <div class="row spacer ">
        <div class="col-md-6 text-left">

        </div>
        {{ Form::open(['url' =>env('APP_URL').'/admin/users/search']) }}
        <div class="col-md-4 text-right">

            {{Form::text('user_search','',['class'=>'form-control col-md-4','autocomplete'=>'off','tabindex'=>1,'placeholder'=>'Search by Username or email...'])}}
            <div class="errors">{{$errors->first('user_search')}}</div>
        </div>
        <div class="col-md-2 text-right">
            {{ Form::submit('Search Accounts',['class'=>'btn btn-primary','style'=>"margin-right:0px;"]) }}

        </div>
        {{ Form::close() }}
    </div>
    <div class="col-md-12">
        <div class="row userGridRowHeader">
            <div class="col-md-2 userGridColHeader" >Name</div>
            <div class="col-md-3 userGridColHeader" >Username</div>
            <div class="col-md-3 userGridColHeader" >Company</div>
            <div class="col-md-1 userGridColHeader" >&nbsp;</div>
            <div class="col-md-2 userGridColHeader" >&nbsp;</div>
            <div class="col-md-1 userGridColHeader" >&nbsp;</div>

        </div>

        @foreach ($users as $user)
            <div class="row altBG">
                <div class="col-md-2 userGridColItem">{{$user->first_name}} {{$user->last_name}}</div>
                <div class="col-md-3 userGridColItem">{{$user->username}}</div>
                <div class="col-md-3 userGridColItem">{{$user->company_name}}</div>
                <div class="col-md-2 userGridColItem"><a href="/users/{{$user->id}}/impersonate">impersonate</a></div>
                <div class="col-md-2 userGridColItem">@if($user->site_admin) <a href="/users/remove-admin/{{$user->id}}">remove admin</a> @else<a href="/users/make-admin/{{$user->id}}">make admin</a>@endif</div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-6 text-left" style="padding-left: 0px;">
                {{ $users->links() }}
            </div>
            <div class="col-md-6 text-right" style="padding-right: 0px; margin: 20px 0px;">
                @if($search == 'yes')
                    <a href="/admin/users" class="btn btn-secondary" style="margin: 0px;">Show All</a>
                @endif

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

