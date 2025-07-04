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
        max-width: 700px;
        text-align: center;
    }

    .register-box h2 {
        font-weight: 600;
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
        width: 250px;
        height: 250px;
        border-radius: 50%;
        object-fit: cover;
    }

    .text-danger {
        font-size: 14px;
        color: #dc3545;
    }

    .password-container {
        position: relative;
    }

    .password-container input {
        padding-right: 40px;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #a270f8;
    }

    @media (max-width: 768px) {
        .register-container {
            flex-direction: column;
        }

        .doctor-image {
            width: 200px;
            height: 200px;
        }
    }
</style>

<div class="register-container">
    <div class="register-box">
        <h2>Registro de Paciente</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required autofocus>
            @error('nombre')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="apellido_paterno" type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" placeholder="Apellido Paterno" required>
            @error('apellido_paterno')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="apellido_materno" type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" placeholder="Apellido Materno">
            @error('apellido_materno')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Número de Teléfono" required>
            @error('telefono')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <!-- Contraseña -->
            <div class="password-container">
                <input id="password" type="password" name="password" placeholder="Contraseña" required>
                <svg id="eye-open" class="toggle-password" onclick="togglePassword('password')" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5
                             c4.477 0 8.268 2.943 9.542 7
                             -1.274 4.057-5.065 7-9.542 7
                             -4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <!-- Confirmar contraseña -->
            <div class="password-container">
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                <svg id="eye-open-confirm" class="toggle-password" onclick="togglePassword('password-confirm')" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5
                             c4.477 0 8.268 2.943 9.542 7
                             -1.274 4.057-5.065 7-9.542 7
                             -4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>

            <button type="submit">Registrarse</button>

            <div class="text-center mt-3">
                <span class="text-muted">¿Ya tienes una cuenta?</span>
                <a href="{{ route('login') }}" class="text-primary ms-1">Inicia sesión aquí</a>
            </div>
        </form>
    </div>

    <div>
        <img src="{{ asset('images/logo1.png') }}" alt="Doctor Bot" class="doctor-image">
    </div>
</div>
@endsection

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const svg = input.nextElementSibling;
        if (input.type === "password") {
            input.type = "text";
            svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19
                         c-4.478 0-8.269-2.943-9.542-7
                         a10.044 10.044 0 012.293-3.95m3.65-2.577A9.956 9.956 0 0112 5
                         c4.478 0 8.269 2.943 9.542 7
                         a9.978 9.978 0 01-4.432 5.568M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3l18 18" />
            `;
        } else {
            input.type = "password";
            svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.477 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.065 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
</script>
