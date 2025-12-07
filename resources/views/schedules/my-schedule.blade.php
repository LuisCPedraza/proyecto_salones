@extends('layouts.app')
@section('title', 'Mi Horario')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-calendar"></i> Mi Horario</h1>
</div>
<div class="card">
    <div class="card-body">
        @if($assignments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th>Hora</th>
                            <th>Grupo</th>
                            <th>Salón</th>
                            <th>Profesor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                            <tr>
                                <td><strong>{{ ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'][$assignment->day_of_week] ?? 'N/A' }}</strong></td>
                                <td>{{ $assignment->start_time }} - {{ $assignment->end_time }}</td>
                                <td>{{ $assignment->studentGroup->name ?? 'N/A' }}</td>
                                <td>{{ $assignment->classroom->name ?? 'N/A' }}</td>
                                <td>{{ $assignment->professor->user->name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted"><p>No tienes asignaciones registradas</p></div>
        @endif
    </div>
</div>
@endsection
