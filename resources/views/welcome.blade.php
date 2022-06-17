<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .body {
            background: #E9E9E9;
        }
        .auth {
             background: #d5d5d55c;
        }
        .card-body {
             background: #ffffff;
        }
        .card-header {

        }
        .card {
            margin-top: 50px;
            border-radius: 20px;
            padding: 10px;
            background: #E9E9E9;
        }
    </style>
</head>
    <body>
        <div class="text-right nav-link">
        @if (Route::has('login'))
                <div class="card-header auth">
                <div class="hidden">
                    @auth
                        <ul class="navbar-nav ml-auto" style="height: auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="https://secure.gravatar.com/avatar/306b82f7e18caa6098e9ae1841642009?s=150&amp;r=g&amp;d=mm" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="https://secure.gravatar.com/avatar/306b82f7e18caa6098e9ae1841642009?s=150&amp;r=g&amp;d=mm" class="img-circle elevation-2" alt="User Image">
                        <p>
                            Admin
                            <small>Member since May. 2022</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="http://expsys/logout" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
{{--                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>--}}
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
                    </div>
            @endif
        </div>
        <div class="container">
            <div class="card text-center" style="margin-top: 50px">
              <div class="card-header" >
                <h2>{{ env('APP_NAME') }}</h2>
              </div>

              <div class="card-body">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                           <a href="{{ route('searchInput') }}" class="btn btn-block btn-lg  btn-primary">Поиск заболевания</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('home') }}" class="btn btn-block btn-lg btn-primary">Редактирование данных</a>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </body>
</html>
