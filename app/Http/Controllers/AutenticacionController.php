<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutenticacionController extends Controller
{
    public function iniciarSesion(Request $request)
    {
        // Validar los campos de entrada
        $request->validate([
            'usuario' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['USUARIO' => $request->usuario, 'password' => $request->contraseña])) {
            // Si la autenticación es exitosa
            return response()->json(['mensaje' => 'Inicio de sesión exitoso'], 200);
        }

        // Si la autenticación falla
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }

    public function cerrarSesion(Request $request)
    {
        Auth::logout();
        return response()->json(['mensaje' => 'Cierre de sesión exitoso'], 200);
    }
}
