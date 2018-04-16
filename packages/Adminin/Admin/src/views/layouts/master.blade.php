<!DOCTYPE html>
<html lang="en">
<head>

    <title>AdminIn | Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- vendor css -->
    <link href="{!! asset('/theme/lib/font-awesome/css/font-awesome.css') !!}" rel="stylesheet">
    <link href="{!! asset('/theme/lib/Ionicons/css/ionicons.css') !!}" rel="stylesheet">
    <link href="{!! asset('/theme/lib/perfect-scrollbar/css/perfect-scrollbar.css') !!}" rel="stylesheet">
    <link href="{!! asset('/theme/lib/jquery-toggles/toggles-full.css') !!}" rel="stylesheet">
    <link href="{!! asset('/theme/lib/rickshaw/rickshaw.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('/css/custom.css') !!}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    {{--<link rel="stylesheet" href="bower_components/sweetalert2/dist/sweetalert2.min.css">--}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="{!! asset('/theme/css/amanda.css') !!}">

    <style>
        .modal-backdrop {
            z-index: -1 !important;
            opacity: .1 !important;
        }
         .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        #load-this {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url({{ URL::asset('images/loader.gif') }}) center no-repeat #fff;
        }
    </style>
    @yield('newstyle')

</head>

<body>

<div id="load-this">

</div>

<div class="am-header">
    <div class="am-header-left">
        <a id="naviconLeft" href="" class="am-navicon d-none d-lg-flex"><i class="icon ion-navicon-round"></i></a>
        <a id="naviconLeftMobile" href="" class="am-navicon d-lg-none"><i class="icon ion-navicon-round"></i></a>
        <a href="index.html" class="am-logo">Admin In</a>
    </div><!-- am-header-left -->

    <div class="am-header-right">
        <div class="dropdown dropdown-profile">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                <!-- <img src="{{ URL::asset('theme/img/img3.jpg') }}" class="wd-32 rounded-circle" alt=""> -->
                 <span class="logged-name"><span class="hidden-xs-down">{{Auth::user()->name}}</span> <i class="fa fa-angle-down mg-l-3"></i></span>
            </a>
            <div class="dropdown-menu wd-200">
                <ul class="list-unstyled user-profile-nav">
                    <li><a href="/admin/auth/logout"><i class="icon ion-power"></i> Sign Out</a></li>
                </ul>
            </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
    </div><!-- am-header-right -->
</div><!-- am-header -->

<div class="am-sideleft">
    <ul class="nav am-sideleft-tab">
        <li class="nav-item">
            <a href="#mainMenu" class="nav-link active"><i class="icon ion-ios-home-outline tx-24"></i></a>
        </li>
        <li class="nav-item">
            <a href="#emailMenu" class="nav-link"></a>
        </li>
        <li class="nav-item">
            <a href="#chatMenu" class="nav-link"></i></a>
        </li>
        <li class="nav-item">
            <a href="#settingMenu" class="nav-link"></a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="mainMenu" class="tab-pane active">
            <ul class="nav am-sideleft-menu">
              <!-- nav-item -->
                <li class="nav-item">
                    <a href="" class="nav-link with-sub">
                        <i class="ion-android-person-add"></i>
                        <span>USER MANAGEMENT</span>
                    </a>
                    <ul class="nav-sub">
                        <li class="nav-item"><a href="{{url('/admin/users#!/add-users')}}" class="nav-link">Add Users</a></li>
                        <li class="nav-item"><a href="{{url('/admin/users#!/view-users')}}" class="nav-link">View Users</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub">
                        <i class="fa fa-plus-circle"></i>
                        <span>CATEGORIES</span>
                    </a>
                    <ul class="nav-sub">
                        <li class="nav-item"><a href="{{url('/admin/category#!/add-categories')}}" class="nav-link">Add Categories</a></li>
                        <li class="nav-item"><a href="{{url('/admin/category#!/view-categories')}}" class="nav-link">View Categories</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link with-sub">
                        <i class="fa fa-shopping-bag"></i>
                        <span>PRODUCTS </span>
                    </a>
                    <ul class="nav-sub">
                        <li class="nav-item"><a href="{{url('/admin/products#!/add-products')}}" class="nav-link">Add Products</a></li>
                        <li class="nav-item"><a href="{{url('/admin/products#!/view-products')}}" class="nav-link">View Products</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- #mainMenu -->

    </div><!-- tab-content -->
</div><!-- am-sideleft -->

<div class="am-mainpanel">
    <div class="am-pagetitle">
        <h5 class="am-title"></h5>
        <form id="searchBar" class="search-bar" action="index.html">
            {{--<div class="form-control-wrapper">--}}
                {{--<input type="search" class="form-control bd-0" placeholder="Search...">--}}
            {{--</div><!-- form-control-wrapper -->--}}
            {{--<button id="searchBtn" class="btn btn-orange"><i class="fa fa-search"></i></button>--}}
        </form><!-- search-bar -->
    </div><!-- am-pagetitle -->

    <div class="am-pagebody">

        @yield('content')

    </div>
</div><!-- am-mainpanel -->

<script src="{!! asset('/theme/lib/jquery/jquery.js') !!}"></script>
<script src="{!! asset('/theme/lib/popper.js/popper.js') !!}"></script>
<script src="{!! asset('/theme/lib/bootstrap/bootstrap.js') !!}"></script>
<script src="{!! asset('/theme/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') !!}"></script>
<script src="{!! asset('/theme/lib/jquery-toggles/toggles.min.js') !!}"></script>
<script src="{!! asset('/theme/lib/d3/d3.js') !!}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
{{--<script src="{!! asset('/theme/lib/rickshaw/rickshaw.min.js') !!}"></script>--}}
<script src="{!! asset('/theme/lib/Flot/jquery.flot.js') !!}"></script>
<script src="{!! asset('/theme/lib/Flot/jquery.flot.pie.js') !!}"></script>
<script src="{!! asset('/theme/lib/Flot/jquery.flot.resize.js') !!}"></script>
<script src="{!! asset('/theme/lib/flot-spline/jquery.flot.spline.js') !!}"></script>
<script src="{!! asset('/theme/js/amanda.js') !!}"></script>
<script src="{!! asset('/theme/js/ResizeSensor.js') !!}"></script>
{{--<script src="{!! asset('/theme/js/dashboard.js') !!}"></script>--}}


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.5/angular-route.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angular-ui-router/1.0.0-rc.1/angular-ui-router.min.js"></script>
<script src="/js/ng-file-upload.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>

<script>
    $(document).ready(function() {
//         Animate loader off screen
        $("#load-this").fadeOut("slow");
    });
</script>
@yield('script')

</body>
</html>
