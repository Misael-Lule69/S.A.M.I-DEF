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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Estilos integrados -->
<style>
.dashboard-container {
  display: flex;
  min-height: 100vh;
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
}

.sidebar {
  width: 200px;
  background-color: #2c3e50;
  color: white;
  padding: 20px;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 30px;
  text-align: center;
}

.menu ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.menu li {
  padding: 12px 0;
  cursor: pointer;
  border-bottom: 1px solid #34495e;
  transition: all 0.3s ease;
}

.menu li:hover {
  background-color: #34495e;
}

.menu li.active {
  font-weight: bold;
  color: #3498db;
  background-color: #34495e;
}

.main-content {
  flex: 1;
  padding: 30px;
  background-color: #f5f7fa;
}

h1 {
  color: #2c3e50;
  margin-bottom: 30px;
  font-size: 24px;
}

.stats-card {
  background: white;
  border-radius: 10px;
  padding: 25px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  margin-bottom: 30px;
}

.stats-card h3 {
  color: #2c3e50;
  margin-top: 0;
  margin-bottom: 20px;
  font-size: 18px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.stat-item {
  text-align: center;
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 8px;
}

.stat-number {
  display: block;
  font-size: 28px;
  font-weight: bold;
  color: #2c3e50;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 14px;
  color: #7f8c8d;
  text-transform: uppercase;
}

.upcoming-appointments {
  background: white;
  border-radius: 10px;
  padding: 25px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.upcoming-appointments h2 {
  color: #2c3e50;
  margin-top: 0;
  font-size: 20px;
}

.upcoming-appointments p {
  color: #7f8c8d;
  margin-bottom: 20px;
  font-size: 14px;
}

.appointment-list {
  margin-top: 15px;
}

.appointment-item {
  padding: 15px 0;
  border-bottom: 1px solid #ecf0f1;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.appointment-item:last-child {
  border-bottom: none;
}

.patient-name {
  font-weight: bold;
  color: #2c3e50;
  font-size: 16px;
}

.appointment-details {
  color: #7f8c8d;
  font-size: 14px;
}
</style>