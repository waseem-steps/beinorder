<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/ico"/>
    <meta name="_token" content="{{ csrf_token() }}">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.js" integrity="sha512-1lagjLfnC1I0iqH9plHYIUq3vDMfjhZsLy9elfK89RBcpcRcx4l+kRJBSnHh2Mh6kLxRHoObD1M5UTUbgFy6nA==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js" integrity="sha512-/DXTXr6nQodMUiq+IUJYCt2PPOUjrHJ9wFrqpJ3XkgPNOZVfMok7cRw6CSxyCQxXn6ozlESsSh1/sMCTF1rL/g==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha512-M5KW3ztuIICmVIhjSqXe01oV2bpe248gOxqmlcYrEzAvws7Pw3z6BK0iGbrwvdrUQUhi3eXgtxp5I8PDo9YfjQ==" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap-grid.min.css" integrity="sha512-pkOzvsY+X67Lfs6Yr/dbx+utt/C90MITnkwx8X5fyKkBorWHJLlR3TmgNJs83URAR0GdejZZnjZdgYjzL/mtcQ==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap-reboot.min.css" integrity="sha512-gl/07tE1atRY5leOa5GtQa/pclV529xEP5cDTIdU1rj7vDh4KKz3nHrP7DsTBx3F++ihOqZGdcRTfOvrU/JF4g==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha512-kBFfSXuTKZcABVouRYGnUo35KKa1FBrYgwG4PAx7Z2Heroknm0ca2Fm2TosdrrI356EDHMW383S3ISrwKcVPUw==" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.js" integrity="sha512-giNJUOlLO0dY67uM6egCyoEHV/pBZ048SNOoPH4d6zJNnPcrRkZcxpo3gsNnsy+MI8hjKk/NRAOTFVE/u0HtCQ==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.min.js" integrity="sha512-N4T9zTrqZUWCEhVU2uD0m47ADCWYRfEGNQ+dx/lYdQvOn+5FJZxcyHOY68QKsjTEC7Oa234qhXFhjPGQu6vhqg==" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.css" integrity="sha512-AuLN6bHjJzqZ+Iw48+GdQPp5uKBdPX6+zWV37ju9zw7XIrevIX01RsLtpTU/zCoQcKrQRPe/EpwDpZiv7OUYMA==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.min.css" integrity="sha512-oG+0IPCSL2awaygM/2l1hPUgHDNnOWji9utPHodoAGbXwLH9yvgD7uRjFxdiKnDr+rx8ejxXYSsUBkcKFR7i0w==" crossorigin="anonymous" />

    <title>{{ config('app.name', 'Beinorder') }}</title>
    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('css/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('css/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ asset('css/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('css/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('css/build/css/custom-rtl.css') }}" rel="stylesheet">
</head>

<body class="nav-md">
    {{ Session::put('client_ip',$_SERVER['REMOTE_ADDR']) }}
    {{ Session::put('ip_address',$_SERVER['REMOTE_ADDR']) }}
    {{ Session::put('user_role', 'Anonymous')}}
    @if(Auth::check())
        {{ Session::put('user_role', App\Http\Controllers\RoleController::getUserRole(Auth::id())) }}
    @else
        {{ Session::put('user_role', 'Anonymous') }}
    @endif
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ Route('dummy') }}" class="site_title">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <image height="55px" href="{{ asset('images/logo.svg') }}" />
                            </svg>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                @if(Session::get('user_role')=='Administrator')
                                <li><a href="{{Route('subs.pending')}}"><i class="fa fa-home"></i>Subscriptions</a></li>
                                <li><a href="{{Route('countries.index')}}"><i class="fa fa-home"></i>Countries</a></li>
                                <li><a href="{{Route('plans.index')}}"><i class="fa fa-home"></i> External Price Plans </a></li>
                                <li><a href="{{Route('plans.index_internal')}}"><i class="fa fa-home"></i> Internal Price Plans </a></li>
                                <li><a href="{{Route('orders.index')}}"><i class="fa fa-book"></i> Orders </a></li>
                                <li><a href="{{Route('orders.index-table')}}"><i class="fa fa-book"></i> Internal Orders </a></li>
                                <li><a href="{{Route('orders.table-orders')}}"><i class="fa fa-newspaper-o"></i> Table Invoice </a></li>
                                @endif
                                @if(Session::get('user_role')=='Restaurant Admin')
                                    @if(App\Http\Controllers\PricePlanController::getPlanTypeByRest(Session::get('rest_id')) == 1)
										<li><a href="{{Route('product-categories.rest-cat-table',Session::get('rest_id'))}}"> <i class="fa fa-home"></i> Product Categories </a></li>
                                        <li><a href="{{Route('table.index',Session::get('rest_id'))}}"> <i class="fa fa-coffee"></i>Tables</a></li>
                                        <li><a href="{{Route('orders.index-table')}}"><i class="fa fa-book"></i>Orders</a></li>
                                        <li><a href="{{Route('orders.table-orders')}}"><i class="fa fa-newspaper-o"></i>Table Invoice</a></li>
										<li><a href="{{Route('orders.history-orders')}}"><i class="fa fa-newspaper-o"></i>History Invoice</a></li>
										<li><a href="{{Route('restaurant.admin_settings',Session::get('rest_id'))}}"><i class="fa fa-cogs"></i>Admin Settings</a></li>
                                    @endif
                                    @if(App\Http\Controllers\PricePlanController::getPlanTypeByRest(Session::get('rest_id')) == 0)
										<li><a href="{{Route('restaurants.active')}}"><i class="fa fa-home"></i> Restaurants</a></li>
                                        <li><a href="{{Route('orders.index')}}"><i class="fa fa-book"></i> Orders </a></li>
										<li><a href="{{Route('restaurant.admin_settings',Session::get('rest_id'))}}"><i class="fa fa-cogs"></i>Admin Settings</a></li>
                                    @endif
                                @endif
                                @if(Session::get('user_role')=='Branch Admin')
									<li><a href="{{Route('orders.index')}}"><i class="fa fa-book"></i> Orders </a></li>
                                @endif
                                @if(Session::get('user_role')=='Anonymous')
									{{-- <li><a href="{{Route('restaurants.active')}}"><i class="fa fa-home"></i> Restaurants</a></li> --}}
									<li><a href="{{Route('orders.index')}}"><i class="fa fa-book"></i> Your Orders </a></li>
									<li><a href="{{Route('orders.table-orders')}}"><i class="fa fa-newspaper-o"></i> Table Invoice </a></li>
                                @endif

                                <!-- ...................................................................... -->
									@if(Session::get('user_role')=='Restaurant Admin')
									<audio id="xyz" src="{{ asset('sounds\bell_ring.mp3') }}" preload="auto"></audio>
									<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

									<script>
										var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
												  cluster: '{{env("PUSHER_APP_CLUSTER")}}',
												  encrypted: true
												});
												 var c='notify-channel'+'{{Auth::id()}}';
												var channel = pusher.subscribe(c);

												channel.bind('App\\Events\\Notify', function(data) {

											 document.getElementById('xyz').play();
													new PNotify({
													title: 'New Order',
													text: 'New Order has been submitted',
													type: 'info',
													styling: 'bootstrap3'
													});
												});
									</script>
									@endif
								<!-- ...................................................................... -->

                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars" style="color:#212529"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li>
                                <a href="#" class="btn btn-success">ع</a>
                            </li>
                            @if(Session::get('user_role')=='Anonymous')
                            @if(App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address'))>0)
                            <li role="presentation">
                                <a href="#" class=" info-number" aria-expanded="false">
                                    <small><a href="{{ Route('cart.active-cart') }}" class="btn btn-success"><i
                                                class="fa fa-shopping-cart"></i><span class="badge bg-green">
                                                &nbsp;{{ App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address')) }}</span></small></a>
                                </a>
                            </li>
                            @endif
                            @endif
                            <li>
                                @guest
                                <a class="btn btn-success" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @else
                                <a class="btn btn-success" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                @endguest
                            </li>
                            <li>
                                <form name="search_rest" action="{{ Route('restaurants.search') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="rest_name" id="rest_name" class="form-control"
                                            placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Go!</button>
                                        </span>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            @yield('content')
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Powered by <a target="_blank" href="http://www.shahin-eng.com/">SEF</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('js/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('js/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Dropzone.js -->
    <script src="{{ asset('js/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('js/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('js/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('js/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('js/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('js/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vendors/pdfmake/build/vfs_fonts.js') }}"></script>

    <!-- FastClick -->
    <script src="{{ asset('js/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- jQuery Smart Wizard -->
    <script src="{{ asset('js/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>

    <!-- jQuery PNotify -->
    <script src="{{ asset('js/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('js/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('js/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('js/build/js/custom.min.js') }}"></script>
</body>
</html>

