<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;
use Kreait\Firebase\JWT\IdTokenVerifier;


class UserController extends ApiController
{

    //Register and Login.
    public function login(Request $request)
    {
        //Verificar el token de Firebase y extraer userId.
        $projectId = 'challenge-daf61';
        $idToken = $request->token;
        $verifier = IdTokenVerifier::createWithProjectId($projectId);
        try {
            $result = $verifier->verifyIdToken($idToken);
            $payload = $result->payload();
            $email = $payload['email'];
        } catch (IdTokenVerificationFailed $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        //Verificar si el usuario ya esta registrado.
        $usuario = $user = User::where('email', $email)->first();
        if ($usuario) {
            $token = $user->createToken('myapptoken')->plainTextToken;
        } else {
            $user = User::create([
                'email' => $email
            ]);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        return response()->json(['backToken' => $token], 200);
    }

    //Logged?.
    public function logeado(Request $request)
    {
        $usuario = auth('sanctum')->user();
        if ($usuario) {
            return response()->json(['message' => true], 200);
        }
        return response()->json(['message' => false], 200);
    }

    //Logout.
    public function Logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['messege' => 'Logged Out'], 200);
    }
}
