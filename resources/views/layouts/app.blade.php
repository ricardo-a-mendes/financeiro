<!DOCTYPE html>
<!-- TODO: Refactor views into respective folders -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        a.deco-none {color:#000000 !important; text-decoration:none;}
        .cursor-pointer {cursor: pointer;}
        .text-red {color: red;}
        .text-green {color: green;}
        body {
            background-color: white !important;
        }
    </style>

    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand form-inline" href="{{ url('/') }}">
                        <div class="row">
                            <div class="col-md-3"><img src="{{asset('image/logo_24.png')}}"></div>
                            <div class="col-md-9">{{ config('app.name', 'Laravel') }}</div>
                        </div>
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    @if (Auth::check())
                    <ul class="nav navbar-nav">
                        <li><a href="{{route('statement')}}">{{trans('app.menu.extract_monthly')}}</a></li>
                        <li><a href="{{route('statement')}}">{{trans('app.menu.extract_yearly')}}</a></li>
                        <li><a href="{{route('statement')}}">{{trans('app.menu.statement')}}</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{trans('app.menu.settings')}} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                {{--<li><a href="{{route('account.index')}}">{{trans_choice('account.labels.account', 2)}}</a></li>--}}
                                <li><a href="{{route('category.index')}}">{{trans_choice('category.labels.category', 2)}}</a></li>
                                <li><a href="{{route('provision.index')}}">{{trans_choice('provision.labels.provision', 2)}}</a></li>
                                <li><a href="{{route('reference.index')}}">{{trans_choice('reference.labels.reference', 2)}}</a></li>
                            </ul>
                        </li>
                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">{{trans('app.menu.login')}}</a></li>
                            <li><a href="{{ url('/register') }}">{{trans('app.menu.register')}}</a></li>
                        @else
                            <li role="presentation" class="active"><a href="#">{{trans('app.menu.alerts')}} <span class="badge">2</span></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{url('/my_account')}}">{{trans('app.menu.user_account')}}</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{trans('app.menu.logout')}}
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="container">
            <div class="row">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>Well done \o/ - </strong> {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap :(</strong> {{ Session::get('error') }}
                    </div>
                @endif

                @if (Session::has('info'))
                    <div class="alert alert-info" role="alert">
                        <strong>Heads up! </strong> {{ Session::get('info') }}
                    </div>
                @endif
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap/dropdown.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap/tooltip.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @yield('js')
    @yield('js_modal')
</body>
</html>
