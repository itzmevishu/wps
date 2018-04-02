<!doctype html>
<html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#" class="js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11"/>
    <title>Store</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel='stylesheet prefetch' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>

    <link rel="stylesheet" href="{{$custom_css_file}}?v={{time()}}">

    <link rel="stylesheet"href="//codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <style type="text/css">
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px;
            border-radius: 0 6px 6px 6px;
        }

        .dropdown:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-submenu>a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }

        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }


    </style>

</head>
<body>

<!-- End Google Tag Manager -->
<nav class="navbar navbar navbar-fixed-top nav_ecomm" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div style="margin-top: 6px;margin-left: 7px;">
                <div class="pull-left"><a class="navbar-brand" href="/"><img src="{{asset('/images/wps_logo.png')}}"></a></div>
                @if (! Auth::check())

                    <div class="pull-right navbar-registerBtn"><a class="btn btn-primary" href="/new-account">Register Now</a></div>

                @endif
            </div>
        </div>

        <div id="navbar" class="collapse navbar-collapse navbar-right" style="margin-top:55px">
            <ul class="nav navbar-nav">
                @if (Auth::check())

                    @if(Auth::user()->isImpersonating())
                        <li><a href="/users/stop">Stop Impersonate</a></li>
                    @endif

                @endif
                <li>
                    <a href="/store-catalog">Catalog</a>
                </li>
                    <li>
                        <a href="/iltsessions">Live Sessions </a>
                    </li>
                <li>
                    <a href="/show-cart">Cart ( <span id="cartCount"> {{$cartCount}} </span> ) <i class="glyphicon glyphicon-shopping-cart"></i></a>
                </li>
                @if (Auth::check())
                    <li class="divider-vertical"></li>
                    <li><a href="/sso">My Dashboard</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            {{$userAuth->first_name}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" style="right: auto;">
                            <li><a href="/account/profile">Profile</a></li>
                            <li><a href="/orders/show-orders">Orders</a></li>

                            <li role="separator" class="divider"></li>
                            @if($userAuth->site_admin == 1)
                                <li><a href="/admin">Admin</a></li>
                                <li><a href="/settings/create">Welcome Message</a></li>
                                <li role="separator" class="divider"></li>

                            @endif

                            <li><a href="/logout">Logout</a></li>
                        </ul>

                    </li>
                @else
                    <li class="divider-vertical"></li>
                    <li><a href="/login">Login</a> </li>
                @endif

            </ul>

        </div><!--/.nav-collapse -->


    </div>
    <div id="secondary-nav" style="padding-left: 0px;margin-top: 0px;">
        <div class="container" style="padding-left: 8px;height: 45px;">

            <ul class="">

                @foreach($menu as $key => $menuItem)
                    <li class="dropdown">
                        <a class="dropdown-toggle"  href="/catalog/{{$key}}/all/all" role="button" aria-expanded="false">
                            {{ $key }}
                            <span class="caret"></span>
                        </a>
                        @if(is_array($menuItem))
                            <ul class="dropdown-menu multi-level">
                            @foreach($menuItem as $sKey => $sMenuItem)
                                <li class="dropdown-submenu">
                                    <a href="/catalog/{{$key}}/{{$sKey}}/all" >{{$sKey}}</a>
                                    @if(is_array($sMenuItem))
                                        <ul class="dropdown-menu">
                                            @foreach($sMenuItem as $tKey => $tInfo)
                                                @if($tInfo['name'] != "")
                                                    <li><a href="/catalog/{{$key}}/{{$sKey}}/{{$tInfo['id']}}">{{$tInfo['name']}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach

            </ul>


            <div class="navbar-searchForm">
                @if (Request::is('iltsessions/*') || Request::is('iltsessions'))
                    {{ Form::open(['url' => '', 'id' => 'search_sessions']) }}
                    <input type="input"  id="search_terms" name="search_terms" @if(isset($searchTerm) and $searchTerm != '') value="{{$searchTerm}}" @endif class="form-control" placeholder="search sessions here..." style="margin-top: 6px; width: 45%;display:inline;">
                    <input type="submit" value="Search" name="Search" class="btn btn-secondary"  style="min-width:100px;margin-top:0px;margin-left:5px;margin-right:0px;">
                    {{ Form::close() }}
                    <div class="errors">{{$errors->first('search_terms')}}</div>
                @else
                    {{ Form::open(['url' => env('APP_URL').'/catalog-search']) }}
                    <input type="input" name="search_terms" @if(isset($searchTerm) and $searchTerm != '') value="{{$searchTerm}}" @endif class="form-control" placeholder="Enter search terms here..." style="margin-top: 6px; width: 45%;display:inline;">
                    <input type="submit" value="Search" name="Search" class="btn btn-secondary"  style="min-width:100px;margin-top:0px;margin-left:5px;margin-right:0px;">
                    {{ Form::close() }}
                    <div class="errors">{{$errors->first('search_terms')}}</div>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top:135px;border:0px solid black;">
    <div id="wrap">
        <div id="main" class="container clear-top">
            @yield('content')
            <!--
            <div class="push"></div>
            -->
        </div>
    </div>
</div>
<!--
<footer >
    <div class="container">
        <div class="footer-item">
            <a href="faqs" ><strong>Frequently Asked Questions</strong></a>
        </div>

    </div>
</footer>
-->

<footer>
    <div style="min-height: 250px;" class="footer" id="footer-sub">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5> Have a Question? </h5>
                    <ul>
                        <li><a href="faqs" >FAQ</a><hr></li>
                        <li><a href="mailto:surveymail@wpsic.com">surveymail@wpsic.com</a><hr></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5> Helpful Websites </h5>
                    <ul>
                        <li><a href=""><a href="http://www.wpsgha.com">WPS GHA Portal</a><hr></li>
                        <li><a href=""><a href="http://www.cms.gov">CMS Website</a><hr></li>
                    </ul>
                </div>
<!--
                <div class="col-md-4">
                    <h5> MISC </h5>
                    <ul>
                        <li><a href="">Online Shopping</a><hr></li>
                        <li><a href="">Affliate Program</a><hr></li>
                        <li><a href="">Gift Card</a><hr></li>
                        <li><a href="">Subscription</a><hr></li>
                        <li><a href="">Sitemap</a></li>
                    </ul>
                </div>
-->
            </div>
        </div>
    </div>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//codeorigin.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

<script>
    $(function () {
        var __searchTerm = "all";

        $( "#search_sessions" ).submit(function( event ) {
            __searchTerm = $("#search_terms").val();
            window.location.replace("{{ env('APP_URL') }}/iltsessions/"+ __searchTerm +"/name_asc");
            event.preventDefault();
        });

    });
</script>

@yield('scripts')
<style>
    #footer-sub{
        background-color: #fff;
        border-top: 1px solid #dbdbdb;
    }

    #footer-main{
        background-color: #012b72;
    }

    #footer-sub h5{
        color:#565656;
        margin-top: 25px;
    }

    #footer-sub ul{
        list-style: none;
        margin-top: 20px;
    }

    #footer-sub hr{
        margin: 5px;

    }

    #footer-sub ul li{
        margin-left: -38px;
    }

    #footer-sub a:link {
        text-decoration: none;
        color:#565656;
        font-size: 12px;
    }

    #footer-sub a:visited {
        text-decoration: none;
        color:#565656;
    }


    #footer-sub a:hover {
        text-decoration: none;
        color: blue;
    }


    #footer-sub a:active {
        text-decoration: none;
        color:#565656;
    }

    .vertical-line{
        border-right: 1px solid #dbdbdb;
        margin: 8px;
        padding: 0px;
    }

    #sub-two{
        margin: 0px;
        padding: 0px;
    }

    #sub-two .vertical-line h4{
        color:#6d6c6c;
    }


    #footer-main ul{
        list-style: none;
    }

    #footer-main ul li{
        float:left;
        text-decoration: none;
        padding-left: 15px;
        margin-top: 17px;
    }

    #footer-main a:link {
        color:white;
        font-size: 12px;
    }

    #footer-main a:visited {
        color:white;
    }


    #footer-main a:hover {
        text-decoration: none;
        color: #00b9f5;
    }


    #footer-main a:active {
        color:white;
    }

    .glyphicon-search{
        font-size: 20px;
    }

    #social-menu{
        float: right;
        margin-right: 60px;
    }

    #side-padding{
        padding: 0px;
        margin: 0px;
    }
</style>
</body>
</html>