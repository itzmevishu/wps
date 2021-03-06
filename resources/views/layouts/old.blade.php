<!doctype html>
<html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#" class="js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11"/>
    <title>Store</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">



    <link rel="stylesheet" href="{{$custom_css_file}}">
    <link rel="stylesheet"href="//codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <style type="text/css">
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
                <div class="pull-left"><a class="navbar-brand" href="/"><img src="{{$logo}}"></a></div>
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
                    <a href="/show-cart">Cart ( {{$cartCount}} ) <i class="glyphicon glyphicon-shopping-cart"></i></a>
                </li>
                @if (Auth::check())
                    <li class="divider-vertical"></li>
                    <li><a href="/sso">My Courses</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            {{$userAuth->first_name}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" style="right: auto;">
                            <li><a href="/account/profile">Profile</a></li>
                            <li><a href="/orders/show-orders">Orders</a></li>
                            <li><a href="/account/register-vehicle">Register Vehicle</a></li>
                            <li role="separator" class="divider"></li>
                            @if($userAuth->site_admin == 1)
                                <li><a href="/admin">Admin</a></li>

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
                @foreach($menuArray as $menuItem)
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="" role="button" aria-expanded="false">
                            {{$menuItem['parent']}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" style="right: auto;">
                            @foreach($menuItem['child'] as $menuChildItem)
                                <li><a href="/catalog/{{$menuItem['parent']}}/{{$menuChildItem['childname']}}/{{$menuChildItem['childid']}}">{{$menuChildItem['childname']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <div class="navbar-searchForm">
                {{ Form::open(['url' => env('APP_URL').'/catalog-search']) }}
                <input type="input" name="search_terms" @if(isset($searchTerm) and $searchTerm != '') value="{{$searchTerm}}" @endif class="form-control" placeholder="Enter search terms here..." style="margin-top: 6px; width: 45%;display:inline;">
                <input type="submit" value="Search" name="Search" class="btn btn-secondary"  style="min-width:100px;margin-top:0px;margin-left:5px;margin-right:0px;">
                {{ Form::close() }}
                <div class="errors">{{$errors->first('search_terms')}}</div>
            </div>
        </div>
    </div>
</nav>

<div class="container" style="margin-top:135px;border:0px solid black;">
    <div id="wrap">
        <div id="main" class="container clear-top">
            @yield('content')
            <div class="push"></div>
        </div>
    </div>
</div>
<footer >
    <div class="container">


    </div>

</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//codeorigin.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>


<script>

</script>

@yield('scripts')


</body>
</html>