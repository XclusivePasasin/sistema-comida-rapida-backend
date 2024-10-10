<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth

class AutenticacionController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'usuario' => 'required',
            'contraseña' => 'required',
        ]);

        // Ajustar las credenciales para que coincidan con tu base de datos
        $credentials = [
            'USUARIO' => $request->usuario,        // Coincidir con el nombre de columna "USUARIO"
            'password' => $request->contraseña,    // Laravel espera "password", debemos manejar este campo
        ];

        // Intentar la autenticación
        if (Auth::attempt($credentials)) {
            // Si tiene éxito, regenerar la sesión
            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'Login exitoso',
            ], 200);
        }

        // Si la autenticación falla, retornar error
        return response()->json([
            'status' => 'error',
            'message' => 'Credenciales incorrectas',
        ], 401);
    }
}
