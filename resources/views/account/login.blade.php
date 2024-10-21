<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Favicons-->
    <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('account/images/favicon/apple-touch-icon-152x152.png') }}">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="{{ asset('account/images/favicon/mstile-144x144.png') }}">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->

    <link href="{{ asset('account/css/materialize.min.css') }}" type="text/css" rel="stylesheet"
        media="screen,projection">
    <link href="{{ asset('account/css/style.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="{{ asset('account/css/custom/custom.min.css') }}" type="text/css" rel="stylesheet"
        media="screen,projection">
    <link href="{{ asset('account/css/layouts/page-center.css') }}" type="text/css" rel="stylesheet"
        media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{ asset('account/js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" type="text/css"
        rel="stylesheet" media="screen,projection">

</head>

<body class="cyan">
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->




    <div id="login-page" class="row">
        <div class="col s12 z-depth-4 card-panel">
            <form method="POST" action="{{ route('login') }}" class="login-form" id="form">
                @csrf

                <div class="row">
                    <div class="input-field col s12 center">
                        <p class="center login-form-text">Login</p>
                        @if (Session::get('error_logged_in'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{{ Session::get('error_logged_in') }}</li>
                                </ul>
                            </div>
                        @endif
                        @if (Session::get('success'))
                            <div class="alert alert-success alert-dismissable fade show">
                                <ul>
                                    <li>{{ Session::get('success') }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-social-person-outline prefix"></i>
                        <input name="email" id="username" type="text" class="@error('password') invalid @enderror" value="{{ old('email') }}">
                        <label for="email" class="center-align">Email</label>
                        <!-- error message untuk no_tlp -->
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                <i class="mdi-alert-error"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-action-lock-outline prefix"></i>
                        <input name="password" id="password" type="password" class="@error('password') invalid @enderror" value="{{ old('password') }}">
                        <span style="position:absolute; right:20px; top:20%" class="toggle-btn" onclick="togglePassword()"><i class="fas fa-eye"></i></span>
                        <label for="password">Password</label>
                        <!-- error message untuk no_tlp -->
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                <i class="mdi-alert-error"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="input-field col s6 m6 l6">
                    <button type="submit" class="btn" style="background-color: #499848;">Login</button>
                </div>

                <div class="row">
                    <div class="input-field col s6 m6 l6">
                        <p class="margin medium-small">
                            <a href="{{ route('registrasi') }}" style="float: left; color:green;"
                            onmouseover="this.style.color='blue';"
                            onmouseout="this.style.color='green';">Register Now!</a>
                            <a href="/" style="float: left; color:green;"
                            onmouseover="this.style.color='blue';"
                            onmouseout="this.style.color='green';">Menu Utama</a>
                        </p>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>



    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="{{ asset('account/js/plugins/jquery-1.11.2.min.js') }}"></script>
    <!--materialize js-->
    <script type="text/javascript" src="{{ asset('account/js/materialize.min.js') }}"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="{{ asset('account/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}">
    </script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="{{ asset('account/js/plugins.min.js') }}"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="{{ asset('account/js/custom-script.js') }}"></script>

    <script>

        function togglePassword() {

            const passwordField = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-btn i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }

    </script>
</body>

</html>
