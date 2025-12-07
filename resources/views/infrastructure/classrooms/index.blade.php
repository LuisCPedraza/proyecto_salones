@extends('layouts.app')
@section('title', 'Salones')
@section('content')
<div class="page-header">
    <div><h1><i class="fas fa-door-open"></i> Salones</h1></div>
    <a href="{{ route('infrastructure.classrooms.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Salón</a>
</div>
<div class="card">
    <div class="card-body p-0">
        @if($classrooms->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Capacidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classrooms as $classroom)
                            <tr>
                                <td><strong>{{ $classroom->name }}</strong></td>
                                <td>{{ $classroom->location }}</td>
                                <td><span class="badge bg-info">{{ $classroom->capacity }}</span></td>
                                <td><span class="badge bg-{{ $classroom->status === 'available' ? 'success' : 'warning' }}">{{ $classroom->status }}</span></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('infrastructure.classrooms.edit', $classroom) }}" class="btn btn-outline-warning"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('infrastructure.classrooms.destroy', $classroom) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro?');"><@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button></form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted"><p>No hay salones registrados</p></div>
        @endif
    </div>
</div>
@endsection
