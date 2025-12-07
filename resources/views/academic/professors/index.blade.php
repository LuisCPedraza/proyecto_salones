@extends('layouts.app')
@section('title', 'Profesores')
@section('content')
<div class="page-header">
    <div><h1><i class="fas fa-chalkboard-user"></i> Profesores</h1></div>
    <a href="{{ route('academic.professors.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Profesor</a>
</div>
<div class="card">
    <div class="card-body p-0">
        @if($professors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Especialidades</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($professors as $prof)
                            <tr>
                                <td><strong>{{ $prof->user->name ?? 'N/A' }}</strong></td>
                                <td><small>{{ implode(', ', $prof->specialties ?? []) }}</small></td>
                                <td><span class="badge bg-{{ $prof->status === 'active' ? 'success' : 'secondary' }}">{{ $prof->status }}</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('academic.professors.edit', $prof) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('academic.professors.destroy', $prof) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro?');"><@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted"><p>No hay profesores registrados</p></div>
        @endif
    </div>
</div>
@endsection
