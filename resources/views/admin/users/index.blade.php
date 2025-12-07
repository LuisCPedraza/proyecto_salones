@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="page-header">
    <div>
        <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Usuario
    </a>
</div>

<div class="card">
    <div class="card-header bg-light border-bottom">
        <div class="row g-3">
            <div class="col-md-4">
                <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Buscar por nombre o email..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-4">
                <select name="role" class="form-select form-select-sm" onchange="window.location.href='{{ route('admin.users.index') }}?role=' + this.value">
                    <option value="">Todos los roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm" onchange="window.location.href='{{ route('admin.users.index') }}?status=' + this.value">
                    <option value="">Todos los estados</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendido</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td><small>{{ $user->email }}</small></td>
                                <td>
                                    <span class="badge bg-info">{{ $user->role }}</span>
                                </td>
                                <td>
                                    @if($user->status === 'active')
                                        <span class="badge bg-success">Activo</span>
                                    @elseif($user->status === 'inactive')
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @else
                                        <span class="badge bg-danger">Suspendido</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('¿Estás seguro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay usuarios registrados</p>
            </div>
        @endif
    </div>
</div>
@endsection
