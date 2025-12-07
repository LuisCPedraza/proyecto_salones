@extends('layouts.app')
@section('title', 'Grupos Estudiantiles')
@section('content')
<div class="page-header">
    <div>
        <h1><i class="fas fa-users-class"></i> Grupos Estudiantiles</h1>
    </div>
    <a href="{{ route('academic.student-groups.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Grupo
    </a>
</div>
<div class="card">
    <div class="card-header bg-light">
        <form method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar..." value="{{ request('search') }}">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        @if($studentGroups->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nivel</th>
                            <th>Estudiantes</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentGroups as $group)
                            <tr>
                                <td><strong>{{ $group->name }}</strong></td>
                                <td>{{ $group->level }}</td>
                                <td><span class="badge bg-info">{{ $group->student_count }}</span></td>
                                <td>
                                    @if($group->status === 'active')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('academic.student-groups.edit', $group) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('academic.student-groups.destroy', $group) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-light">
                {{ $studentGroups->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="mt-3">No hay grupos registrados</p>
            </div>
        @endif
    </div>
</div>
@endsection
