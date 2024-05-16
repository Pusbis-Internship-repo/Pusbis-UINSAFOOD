<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title>Registrasi</title>

    <!-- Favicons-->
    <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('account/images/favicon/apple-touch-icon-152x152.png') }}">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="{{ asset('account/images/favicon/mstile-144x144.png') }}">
    <!-- For Windows Phone -->

    <!-- CORE CSS-->
    <link href="{{ asset('account/css/materialize.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('account/css/style.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="{{ asset('account/css/custom/custom.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('account/css/layouts/page-center.css') }}" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{ asset('account/js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- Gaya khusus untuk tombol loading -->
    <style>
        .loading-btn {
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.6;
        }
    </style>

</head>

<body class="cyan">
    <!-- Mulai Loading Halaman -->
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- Selesai Loading Halaman -->

    <div id="login-page" class="row">
        <div class="col s12 z-depth-4 card-panel">
            <form method="POST" action="{{ route('registrasi') }}" class="login-form" id="form">
                @csrf

                <div class="row">
                    <div class="input-field col s12 center">
                        <p class="center login-form-text">Login untuk Sistem Pemesanan Makanan</p>
                        @if (session('error_mail'))
                            <div class="text-danger">
                                {{ session('error_mail') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
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
                        <i class="mdi-av-recent-actors prefix"></i>
                        <input name="nama_lengkap" id="username" type="text">
                        <label for="nama_lengkap" class="center-align">Nama Lengkap</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-social-person-outline prefix"></i>
                        <input name="email" id="username" type="text">
                        <label for="email" class="center-align">Email</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-action-lock-outline prefix"></i>
                        <input name="password" id="password" type="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-action-perm-contact-cal prefix"></i>
                        <input name="no_tlp" id="username" type="text">
                        <label for="no_tlp" class="center-align">No. Telepon</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-action-work prefix"></i>
                        <input name="unit_kerja" id="username" type="text">
                        <label for="unit_kerja" class="center-align">Unit Kerja</label>
                    </div>
                </div>
                <div class="row margin">
                    <div class="input-field col s12">
                        <i class="mdi-action-work prefix"></i>
                        <input name="alamat" id="username" type="text">
                        <label for="alamat" class="center-align">Alamat</label>
                    </div>
                </div>

                <div class="input-field col s6 m6 l6">
                    <button type="submit" class="btn" style="background-color: #499848;" id="regis-btn">Regis</button>
                </div>
                <div class="row">
                    <div class="input-field col s6 m6 l6">
                        <p class="margin medium-small">
                            <a href="{{ route('login') }}" class="text-primary">Login</a>
                        </p>
                        <p class="margin medium-small">
                            <a href="/" style="float: left;">Kembali</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ================================================
    Skrip
    ================================================ -->

    <!-- Perpustakaan jQuery -->
    <script type="text/javascript" src="{{ asset('account/js/plugins/jquery-1.11.2.min.js') }}"></script>
    <!--materialize js-->
    <script type="text/javascript" src="{{ asset('account/js/materialize.min.js') }}"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="{{ asset('account/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <!--plugins.js - Beberapa kode JS khusus untuk Pengaturan Plugin-->
    <script type="text/javascript" src="{{ asset('account/js/plugins.min.js') }}"></script>
    <!--custom-script.js - Tambahkan JS tema kustom Anda sendiri-->
    <script type="text/javascript" src="{{ asset('account/js/custom-script.js') }}"></script>

    <!-- Skrip JavaScript khusus untuk menangani pengiriman form -->
    <script type="text/javascript">
        document.getElementById('form').addEventListener('submit', function() {
            var regisBtn = document.getElementById('regis-btn');
            regisBtn.innerHTML = 'Loading...';
            regisBtn.classList.add('loading-btn');
            regisBtn.disabled = true;
        });
    </script>

</body>

</html>
