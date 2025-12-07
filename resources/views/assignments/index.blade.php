@extends('layouts.app')
@section('title', 'Asignaciones')
@section('content')
<div class="page-header">
    <div><h1><i class="fas fa-calendar-check"></i> Asignaciones</h1></div>
    <a href="{{ route('assignments.assignments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Asignación</a>
</div>
<div class="card">
    <div class="card-body p-0">
        @if($assignments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Profesor</th>
                            <th>Salón</th>
                            <th>Horario</th>
                            <th>Semestre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->studentGroup->name ?? 'N/A' }}</td>
                                <td>{{ $assignment->professor->user->name ?? 'N/A' }}</td>
                                <td>{{ $assignment->classroom->name ?? 'N/A' }}</td>
                                <td><small>{{ ['Lun','Mar','Mié','Jue','Vie','Sáb'][$assignment->day_of_week] ?? 'N/A' }} {{ $assignment->start_time }}-{{ $assignment->end_time }}</small></td>
                                <td>{{ $assignment->semester }}</td>
                                <td><span class="badge bg-{{ $assignment->status === 'active' ? 'success' : 'warning' }}">{{ $assignment->status }}</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('assignments.assignments.edit', $assignment) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('assignments.assignments.destroy', $assignment) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro?');"><@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted"><p>No hay asignaciones registradas</p></div>
        @endif
    </div>
</div>
@endsection
