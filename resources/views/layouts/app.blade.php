<!doctype html>
<html lang="en">
<head>
    <title>@yield("title")</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/assets/css/material-dashboard.css">
</head>
<body>
<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
            <a href="{{route("home")}}" class="simple-text logo-normal">
                Lirabet Panel
            </a>
        </div>
        <div class="sidebar-wrapper ps-container ps-theme-default" data-ps-id="36962c5b-ae00-81ae-afd3-8dc0af67cfb3">
            <ul class="nav">

                <li class="nav-item {{ Route::currentRouteNamed('home') ? 'active' : '' }} ">
                    <a class="nav-link" href="{{route("home")}}">
                        <i class="material-icons">dashboard</i>
                        <p>Genel Görünüm</p>
                    </a>
                </li>


                <li class="nav-item {{ Route::currentRouteNamed('number') ? 'active' : '' }} ">
                    <a class="nav-link" href="{{route("number")}}">
                        <i class="material-icons">dashboard</i>
                        <p>Telefon Numaraları</p>
                    </a>
                </li>

                <li class="nav-item {{ Route::currentRouteNamed('process') ? 'active' : '' }} ">
                    <a class="nav-link" href="{{route("process")}}">
                        <i class="material-icons">dashboard</i>
                        <p>İşlemler</p>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link"  href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                        <i class="material-icons">close</i>
                        <p>Çıkış Yap</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>



            </ul>
            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
        <div class="sidebar-background" style="background-image: url(../assets/img/sidebar-1.jpg) "></div>
    </div>
    <div class="main-panel ps-container ps-theme-default ps-active-y" data-ps-id="f3637c37-3dd0-99e5-b189-7fa89def2663">
        <div class="content" style="margin-top:0">
            <div class="container-fluid">

                @if(session("type"))
                    <div class="alert alert-{{session("type")}}">{{session("message")}}</div>
                @endif
                @yield("content")
            </div>
        </div>
        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px; height: 657px;">
            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 347px;"></div>
        </div>
    </div>
</div>


<script src="/assets/js/core/jquery.min.js"></script>
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap-material-design.min.js"></script>
<script src="/assets/js/plugins/bootstrap-notify.js"></script>
<script src="/assets/js/core/chartist.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="/assets/js/material-dashboard.js?v=2.1.0"></script>


@yield("script")

</body>
</html>