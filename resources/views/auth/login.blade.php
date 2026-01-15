@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    #app {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        width: 100%;
        padding: 20px;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        background: white;
        max-width: 500px;
        margin: 0 auto;
    }

    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
        border: none;
    }

    .login-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 28px;
        white-space: nowrap;
    }

    .login-header p {
        margin: 10px 0 0 0;
        font-size: 14px;
        opacity: 0.9;
    }

    .login-body {
        padding: 40px 30px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 20px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 14px 40px;
        font-weight: 600;
        transition: transform 0.3s, box-shadow 0.3s;
        width: 100%;
        font-size: 16px;
        color: white;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-label {
        font-size: 14px;
        color: #666;
    }

    .forgot-password {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: color 0.3s;
    }

    .forgot-password:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
        color: #666;
        font-size: 14px;
    }

    .register-link a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
    }

    .register-link a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    @media (max-width: 576px) {
        .login-header h4 {
            font-size: 24px;
        }

        .login-header p {
            font-size: 13px;
        }

        .login-body {
            padding: 30px 20px;
        }
    }
</style>

<div class="container-fluid login-container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card login-card">
                <div class="login-header">
                    <h4>Welcome Back!</h4>
                    <p>Sign in to continue to Thalassemia</p>
                </div>

                <div class="card-body login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Username</label>
                            <input id="email"
                                   type="text"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus
                                   placeholder="Enter username">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input id="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Enter your password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap">
                            <div class="form-check mb-2 mb-sm-0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="remember"
                                       id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="forgot-password" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-login">
                                Sign In
                            </button>
                        </div>

                        @if (Route::has('register'))
                            <div class="register-link">
                                Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
