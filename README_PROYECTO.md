# Sistema de Asignación de Salones para Centro Educativo

## Descripción
Sistema web completo desarrollado en Laravel 11 para la gestión integral de recursos educativos (grupos, salones, profesores) y la programación semestral de asignaciones, tanto automática como manualmente.

## Características Principales

### 8 Módulos Implementados

#### Módulo 1: Autenticación y Gestión de Accesos
- Login multi-rol con credenciales
- Gestión de sesiones por rol
- Control de acceso basado en permisos (RBAC)
- Activación/desactivación temporal para profesores invitados
- Validación de acceso expirado

#### Módulo 2: Administración del Sistema
- CRUD de usuarios con asignación de roles
- Panel de métricas y estadísticas
- Configuración de períodos académicos
- Monitorización del sistema
- Generación de reportes

#### Módulo 3: Gestión Académica
- Registro y edición de grupos estudiantiles
- Gestión de información de profesores
- Control de disponibilidades horarias
- Triggers de auditoría para cambios críticos

#### Módulo 4: Gestión de Infraestructura
- Catálogo de salones con características técnicas
- Gestión de recursos y equipamientos
- Control de disponibilidad y restricciones físicas
- Particionamiento por ubicaciones geográficas

#### Módulo 5: Sistema de Asignación Inteligente
- Motor de asignación con algoritmo de scoring
- Panel de configuración de prioridades
- Interfaz visual interactiva (drag & drop)
- Sistema de notificación de conflictos

#### Módulo 6: Visualización y Análisis de Horarios
- Vista consolidada para coordinación
- Vista personalizada por profesor
- Filtros y búsquedas avanzadas
- Exportación de horarios

#### Módulo 7: Gestión de Conflictos y Restricciones
- Motor de detección de conflictos
- Generación de alternativas automáticas
- Gestión de reglas de restricción
- Panel de resolución de incidencias

#### Módulo 8: Portal de Profesores
- Edición de disponibilidad personal
- Visualización de asignaciones
- Interfaz simplificada y responsive
- Acceso temporal controlado para invitados

## Roles de Usuario

1. **Administrador**: Acceso total al sistema
2. **Secretaria Administrativa**: Gestión de usuarios y reportes
3. **Coordinador**: Gestión académica y asignaciones
4. **Secretaria de Coordinación**: Apoyo a coordinador
5. **Coordinador de Infraestructura**: Gestión de salones
6. **Secretaria de Infraestructura**: Apoyo a infraestructura
7. **Profesor**: Visualización de horario y disponibilidad
8. **Profesor Invitado**: Acceso temporal limitado

## Horarios Universitarios
- **Lunes a Sábado**: 8:00 AM - 9:00 PM
- **Jornada Diurna**: 8:00 AM - 5:00 PM
- **Jornada Nocturna**: 5:00 PM - 9:00 PM
- **Bloques de 1 hora** (estándar universitario)

## Stack Tecnológico

- **Backend**: Laravel 11 (PHP)
- **Base de Datos**: PostgreSQL (Supabase)
- **Frontend**: Blade Templates + Bootstrap 5 + Alpine.js
- **Autenticación**: Laravel Sanctum (API) + Sessions
- **Testing**: PHPUnit + Pest
- **ORM**: Eloquent

## Instalación

### Requisitos Previos
- PHP 8.1+
- Composer
- PostgreSQL 12+
- Node.js 16+ (opcional, para assets)

### Pasos de Instalación

1. **Clonar o descargar el proyecto**
```bash
cd proyecto_salones
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar archivo .env**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de datos en .env**
```
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=salones_db
DB_USERNAME=postgres
DB_PASSWORD=password
```

5. **Ejecutar migraciones**
```bash
php artisan migrate
```

6. **Ejecutar seeders (datos iniciales)**
```bash
php artisan db:seed
```

7. **Iniciar servidor**
```bash
php artisan serve
```

## Usuarios de Prueba

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@salones.local | admin123 | Administrador |
| coordinador@salones.local | coordinador123 | Coordinador |
| profesor@salones.local | profesor123 | Profesor |

## Estructura de Base de Datos

### Tablas Principales

#### Usuarios y Roles
- `users` - Usuarios del sistema
- `roles` - Roles disponibles
- `permissions` - Permisos del sistema
- `role_permissions` - Relación roles-permisos

#### Académica
- `student_groups` - Grupos de estudiantes
- `professors` - Información de profesores
- `professor_availability` - Disponibilidad de profesores
- `professor_special_assignments` - Asignaciones especiales

#### Infraestructura
- `classrooms` - Salones disponibles
- `classroom_availability` - Disponibilidad de salones
- `classroom_restrictions` - Restricciones de salones

#### Asignaciones
- `assignments` - Asignaciones de grupos a salones
- `assignment_history` - Historial de cambios en asignaciones

#### Configuración
- `academic_periods` - Períodos académicos
- `system_settings` - Configuración del sistema

## API Endpoints (Futuro)

El proyecto está preparado para desarrollo de API REST usando Laravel Sanctum.

```
GET    /api/user                          - Obtener usuario autenticado
GET    /api/permissions/{permission}     - Verificar permiso
```

## Configuración de Supabase

Para conectar con Supabase PostgreSQL:

1. Crear proyecto en Supabase
2. Obtener credenciales de conexión
3. Actualizar .env con los datos de Supabase
4. Ejecutar migraciones

## Características de Seguridad

- ✅ Autenticación multi-rol
- ✅ Validación de permisos por rol
- ✅ Protección CSRF
- ✅ Hashing de contraseñas (bcrypt)
- ✅ Auditoría de cambios
- ✅ Control de acceso temporal
- ✅ Validación de entrada

## Próximas Fases (No Incluidas)

- [ ] Automatización con n8n
- [ ] GitHub Actions para CI/CD
- [ ] Despliegue en Render
- [ ] Pruebas unitarias completas
- [ ] Interfaz gráfica avanzada
- [ ] Notificaciones por correo

## Soporte y Documentación

Para más información, consultar:
- `/PLAN_PROYECTO.md` - Plan detallado del proyecto
- Código fuente comentado en `app/` y `routes/`

## Licencia

Proyecto desarrollado para Centro Educativo.

---

**Versión**: 1.0.0  
**Fecha**: Diciembre 2025  
**Estado**: En desarrollo
