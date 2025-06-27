@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Panel de Control</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Bienvenido(a) de vuelta, {{ Auth::user()->name }}</h3>
                    
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Citas Hoy</h5>
                                    <p class="card-text display-4">8</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Pendientes</h5>
                                    <p class="card-text display-4">4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Completadas</h5>
                                    <p class="card-text display-4">6</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Incluir el archivo calendario.blade.php -->
                    @include('calendario')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection