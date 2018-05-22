<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Control Panel</title>
    <style>
        #loader {
            transition: all .3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1s infinite ease-in-out;
            animation: sk-scaleout 1s infinite ease-in-out
        }

        @-webkit-keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                opacity: 0
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 0
            }
        }
    </style>
    @yield('css')
    <link href="{{ app()->make('url')->to('css/style.css') }}" rel="stylesheet">
    @if(App::isLocale('ar'))
    <link href="{{ app()->make('url')->to('css/style-ar.css') }}" rel="stylesheet">
    @endif
</head>

<body class="app">
<div id="loader">
    <div class="spinner"></div>
</div>
<script>
    window.addEventListener('load', function () {
        const loader = document.getElementById('loader');
        setTimeout(function () {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>
<div id="app">
    <flash message="{{ session('flash') }}"></flash>
    @include('control.partials.sidenav')
    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                @if(auth()->check())
                <ul class="nav-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                            <div class="peer"><span class="fsz-sm c-grey-900">{{ auth()->user()->name }}</span></div>
                        </a>
                        <ul class="dropdown-menu fsz-sm">
                            <li class="dropdown-item"><a href="{{ route('profile',auth()->user()->id) }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-user mR-10"></i>
                                    <span>{{ __('labels.profile') }}</span></a></li>
                            <li class="dropdown-item"><a href="{{ route('logout') }}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i
                                            class="ti-power-off mR-10"></i> <span>{{ __('labels.logout') }}</span></a></li>
                        </ul>   
                    </li>
                </ul>
                @endif
                <ul class="nav-left">
                    
                    <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a>
                    </li>
                    <li class="search-box"><a class="search-toggle no-pdd-right" href="javascript:void(0);"><i
                                    class="search-icon ti-search pdd-right-10"></i> <i
                                    class="search-icon-close ti-close pdd-right-10"></i></a></li>
                    <li class="search-input">
                        <input class="form-control" type="text" placeholder="Search...">
                    </li>
                </ul>
            </div>
        </div>
        <main class="main-content bgc-grey-100">
            <div id="mainContent">
                <div class="container-fluid">
              <h4 class="c-grey-900 mT-10 mB-30">@yield('form-title')</h4>
                <div class="row">
                    <div class="bgc-white p-20 bd col-md-12">
                            <error-flash :errorsobject="{{ $errors }}"></error-flash>
                            <h6 class="c-grey-900">@yield('secondary-title','')</h6>
                            <div>@yield('form')</div>
                    </div>
                </div>
            </div>
        </div>
        </main>
        <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600"><span>Copyright © {{ Date('Y') }} Developed by <a
                        href="https://fb.com/3mr.Mahmoud" target="_blank" title="Amr Mahmoud">Amr Mahmoud</a>. All rights reserved.</span>
        </footer>
    </div>
</div>
</body>
<script type="text/javascript" src="{{ app()->make('url')->to('js/app.js') }}"></script>
<script type="text/javascript" src="{{ app()->make('url')->to('js/vendor.js') }}"></script>
<script type="text/javascript" src="{{ app()->make('url')->to('js/bundle.js') }}"></script>
@yield('js','')
</html>