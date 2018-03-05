
<!doctype html>
<html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#" class="js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11"/>
    <title>Altec Store</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{$custom_css_file}}">
    <link rel="stylesheet"href="//codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

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
                
                 <h3>Have a Question?</h3>
                 <div class=" row spacer">
                    <div class="col-md-12">
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="font-size:17px;"></span>
                        &nbsp;<a href="/faqs">FAQs</a> 
                    </div>
                </div>
                 <div class=" row spacer">
                    <div class="col-md-12">
                        <span class="glyphicon glyphicon-phone-alt" aria-hidden="true" style="font-size:17px;"></span>
                        &nbsp;205.408.8260 
                    </div>
                </div>
                <div class=" row spacer">
                    <div class="col-md-12">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true" style="font-size:17px;"></span>
                        &nbsp;sentrypost@altec.com 
                    </div>
                </div>
                <div class=" row spacer">
                    <div class="col-md-12">
                        <span class="glyphicon glyphicon-globe" aria-hidden="true" style="font-size:17px;"></span>
                        &nbsp;<a href="http://www.altec.com/safety/" target="_blank">http://www.altec.com/safety/</a> 
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


    

    @yield('scripts')


</body>
</html>