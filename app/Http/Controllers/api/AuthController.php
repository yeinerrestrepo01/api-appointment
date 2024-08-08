<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Classes\ApiResponseHelper;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function register(StoreUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return ApiResponseHelper::sendResponse(new UserResource($user), 'usuario registrado Exitosamente', 201);
        } catch (\Exception $ex) {
            return ApiResponseHelper::rollback($ex);
        }
    }

    public function login(Request $request)
    {
        // Intenta autenticar al usuario con las credenciales proporcionadas
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        // Obtener el usuario por su correo electrónico
        $user = User::where('email', $request['email'])->first(); // Corrección aquí

        // Crear un token para el usuario autenticado
        $token = $user->createToken('auth_token')->plainTextToken; // Corrección aquí

        // Retornar el token y el tipo de token
        return response()
            ->json([
                'accessToken' => $token, // Corrección de typo en 'accessToken'
                'token_type' => 'Bearer'
            ]);
    }
}
