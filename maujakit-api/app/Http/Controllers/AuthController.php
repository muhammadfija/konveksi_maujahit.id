<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'login_code' => 'required|string',
        ]);

        $admin = Admin::where('login_code', $request->login_code)->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Kode login tidak valid.',
            ], 401);
        }

        // Revoke previous tokens
        $admin->tokens()->delete();

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'admin' => [
                    'id'   => $admin->id,
                    'name' => $admin->name,
                ],
                'token' => $token,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user('sanctum')->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $admin = $request->user('sanctum');
        return response()->json([
            'success' => true,
            'data' => [
                'id'   => $admin->id,
                'name' => $admin->name,
            ],
        ]);
    }
}
