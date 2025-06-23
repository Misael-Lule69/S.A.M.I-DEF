@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(to right, #dbc9fc, #d3b8f7);
        font-family: 'Poppins', sans-serif;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
        gap: 30px;
        flex-wrap: wrap;
        padding: 20px;
    }

    .login-box {
        background: #fff;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .login-box h2 {
        font-weight: 700;
        color: #5a189a;
        margin-bottom: 30px;
    }

    .login-box input {
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 15px;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .login-box button {
        width: 100%;
        background-color: #a270f8;
        color: white;
        font-size: 18px;
        padding: 15px;
        border: none;
        border-radius: 15px;
        cursor: pointer;
        font-weight: 600;
    }

    .login-box button:hover {
        background-color: #8e5de2;
    }

    .forgot-password {
        margin-top: 15px;
        display: block;
        color: #333;
        font-size: 14px;
        text-decoration: underline;
    }

    .doctor-image {
        max-width: 250px;
    }

    @media (max-width: 768px) {
        .login-container {
            flex-direction: column;
        }
        .doctor-image {
            max-width: 200px;
        }
    }
</style>

<div class="login-container">
    <div class="login-box">
        <h2>Iniciar sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nombre de usuario" required autofocus>
            @error('email')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="password" type="password" name="password" placeholder="contraseña" required>
            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <button type="submit">Inicia sesión</button>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </form>
    </div>

    <div>
        <img src="{{ asset('images/doctor_bot.png') }}" alt="Doctor Bot" class="doctor-image">
    </div>
</div>
@endsection

