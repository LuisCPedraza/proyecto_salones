@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Asignación de Salones')

@section('content')
<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p class="text-muted mb-0">Bienvenido, {{ auth()->user()->name }}</p>
    </div>
    <div>
        <span class="badge bg-info">{{ auth()->user()->role }}</span>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Usuarios Totales</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\StudentGroup::count() }}</div>
            <div class="stat-label">Grupos Estudiantiles</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\Professor::count() }}</div>
            <div class="stat-label">Profesores</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\Classroom::count() }}</div>
            <div class="stat-label">Salones</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Asignaciones Recientes</h5>
            </div>
            <div class="card-body">
                @php
                    $recentAssignments = \App\Models\Assignment::with('studentGroup', 'professor', 'classroom')
                        ->latest()
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentAssignments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Grupo</th>
                                    <th>Profesor</th>
                                    <th>Salón</th>
                                    <th>Horario</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAssignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->studentGroup->name ?? 'N/A' }}</td>
                                        <td>{{ $assignment->professor->user->name ?? 'N/A' }}</td>
                                        <td>{{ $assignment->classroom->name ?? 'N/A' }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'][$assignment->day_of_week] ?? 'N/A' }}
                                                {{ $assignment->start_time }} - {{ $assignment->end_time }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($assignment->status === 'active')
                                                <span class="badge bg-success">Activa</span>
                                            @elseif($assignment->status === 'pending')
                                                <span class="badge bg-warning">Pendiente</span>
                                            @else
                                                <span class="badge bg-danger">Cancelada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No hay asignaciones registradas</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información del Usuario</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Nombre</label>
                    <p class="mb-0"><strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <p class="mb-0"><strong>{{ auth()->user()->email }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Rol</label>
                    <p class="mb-0">
                        <span class="badge bg-primary">{{ auth()->user()->role }}</span>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Estado</label>
                    <p class="mb-0">
                        @if(auth()->user()->status === 'active')
                            <span class="badge bg-success">Activo</span>
                        @elseif(auth()->user()->status === 'inactive')
                            <span class="badge bg-secondary">Inactivo</span>
                        @else
                            <span class="badge bg-danger">Suspendido</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0"><i class="fas fa-bell"></i> Notificaciones</h5>
            </div>
            <div class="card-body">
                <p class="text-muted text-center py-4">No hay notificaciones nuevas</p>
            </div>
        </div>
    </div>
</div>
@endsection
