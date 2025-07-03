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
        max-width: 700px;
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
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #a270f8;
    }

    @media (max-width: 768px) {
        .login-container {
            flex-direction: column;
        }

        .doctor-image {
            width: 200px;
            height: 200px;
        }
    }
</style>

<div class="login-container">
    <div class="login-box">
        <h2>Acceso Médico</h2>

        <form method="POST" action="{{ route('medico.login') }}">
            @csrf

            <!-- Cambiar campo de usuario a email -->
<input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
@error('email')
    <span class="text-danger"><strong>{{ $message }}</strong></span>
@enderror

            <div class="password-container">
                <input id="password" type="password" name="password" placeholder="Contraseña" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror

            <button type="submit">Acceder</button>
        </form>
    </div>

    <div>
        <img src="{{ asset('images/logo1.png') }}" alt="Doctor Bot" class="doctor-image">
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const icon = document.querySelector(".toggle-password i");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection