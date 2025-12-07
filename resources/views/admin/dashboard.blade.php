<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistema de Salones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sistema de Asignación de Salones</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Bienvenido, {{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Panel de Administración</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Gestiona usuarios del sistema.</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Ir a Usuarios</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reportes</h5>
                        <p class="card-text">Genera reportes del sistema.</p>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">Ver Reportes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Configuración</h5>
                        <p class="card-text">Configura el sistema.</p>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-primary">Configurar</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-5">
            <div class="card-header">
                <h4>Información del Sistema</h4>
            </div>
            <div class="card-body">
                <p><strong>Usuario:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Rol:</strong> {{ auth()->user()->role }}</p>
                <p><strong>Estado:</strong> {{ auth()->user()->status }}</p>
                <p><strong>Último acceso:</strong> {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d/m/Y H:i:s') : 'Nunca' }}</p>
            </div>
        </div>
    </div>
</body>
</html>
