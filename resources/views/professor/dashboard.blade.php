@extends('layouts.app')
@section('title', 'Mi Perfil - Profesor')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-circle"></i> Mi Perfil</h1>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light"><h5 class="mb-0">Información Personal</h5></div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Estado:</strong> <span class="badge bg-success">{{ auth()->user()->status }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light"><h5 class="mb-0">Disponibilidad</h5></div>
            <div class="card-body">
                <p class="text-muted">Puedes editar tu disponibilidad horaria aquí</p>
                <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Editar Disponibilidad</a>
            </div>
        </div>
    </div>
</div>
@endsection
