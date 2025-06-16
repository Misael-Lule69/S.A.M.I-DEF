@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #dbc9fc, #d3b8f7);
        font-family: 'Poppins', sans-serif;
    }

    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
        gap: 30px;
        flex-wrap: wrap;
        padding: 20px;
    }

    .register-box {
        background: #fff;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
        text-align: center;
    }

    .register-box h2 {
        font-weight: 700;
        color: #5a189a;
        margin-bottom: 30px;
    }

    .register-box input {
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 15px;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .register-box button {
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

    .register-box button:hover {
        background-color: #8e5de2;
    }

    .doctor-image {
        max-width: 250px;
    }

    .text-danger {
        font-size: 14px;
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .register-container {
            flex-direction: column;
        }

        .doctor-image {
            max-width: 200px;
        }
    }
</style>

<div class="register-container">
    <div class="register-box">
        <h2>Crear cuenta</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Nombre" required autofocus>
            @error('name')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required>
            @error('email')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="password" type="password" name="password" placeholder="Contraseña" required>
            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

            <button type="submit">Registrarse</button>
        </form>
    </div>

    <div>
        <img src="{{ asset('images/doctor_bot.png') }}" alt="Doctor Bot" class="doctor-image">
    </div>
</div>
@endsection
