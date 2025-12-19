@extends('layouts.app')

@section('content')
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            max-width: 700px;
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 100%);
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            color: white;
            position: relative;
        }

        .login-left h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .login-left p {
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 15px;
            opacity: 0.95;
        }

        .login-left .hashtag {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
        }

        .dots-pattern {
            position: absolute;
            bottom: 30px;
            left: 30px;
            display: grid;
            grid-template-columns: repeat(4, 20px);
            gap: 6px;
        }

        .dot {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        .login-right {
            flex: 1;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            position: relative;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            width: 60%;
            height: 60%;
            background: white;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        }

        .login-right h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .login-right .subtitle {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #00d4ff;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .forgot-password {
            text-align: right;
            margin-top: 8px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #00d4ff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #00d4ff 0%, #0099ff 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 153, 255, 0.3);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 12px;
            position: relative;
            color: #999;
            font-size: 0.85rem;
        }

        .social-login {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border: 2px solid #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .social-btn:hover {
            border-color: #00d4ff;
            transform: translateY(-2px);
        }

        .social-btn img {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left {
                padding: 40px 30px;
            }

            .login-left h1 {
                font-size: 2rem;
            }

            .dots-pattern {
                display: none;
            }

            .login-right {
                padding: 40px 30px;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-wrapper">
            <!-- Left Side -->
            <div class="login-left">
                <h1>Selamat Datang</h1>
                <p>Mulai kelola produk Anda dengan mudah dengan kontrol kualitas, real time, dan layanan terbaik dengan
                    keamanan terjamin pada harga yang terjangkau.</p>
                <span class="hashtag">#TetapUpdateSelalu</span>

                <div class="dots-pattern">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot" style="opacity: 0.5;"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot" style="opacity: 0.5;"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot" style="opacity: 0.5;"></div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="login-right">
                <div class="logo-section">
                    <a href="" class="logo">
                        <img src="{{ asset('template') }}/assets/img/kaiadmin/logo_gudangku.png" alt="navbar brand"
                            class="navbar-brand" height="80" />
                    </a>
                </div>

                <h2>Masuk</h2>
                <span class="subtitle">Masuk ke akun Anda untuk melanjutkan</span>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Username / Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Kata Sandi">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="forgot-password">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login">
                        MASUK
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
