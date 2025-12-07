<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verificar si el usuario está activo
            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta está inactiva o el acceso ha expirado.',
                ])->withInput();
            }

            // Actualizar último login
            $user->update(['last_login_at' => now()]);

            $request->session()->regenerate();

            // Redirigir según el rol
            return $this->redirectByRole($user);
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ]);
    }

    /**
     * Redirigir según el rol del usuario
     */
    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'coordinador' => redirect()->route('coordinator.dashboard'),
            'coordinador_infraestructura' => redirect()->route('infrastructure.dashboard'),
            'profesor' => redirect()->route('professor.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Obtener usuario autenticado
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Verificar permisos del usuario
     */
    public function checkPermission(Request $request, string $permission)
    {
        $user = $request->user();
        
        if ($user->hasPermission($permission)) {
            return response()->json(['allowed' => true]);
        }

        return response()->json(['allowed' => false], 403);
    }
}
