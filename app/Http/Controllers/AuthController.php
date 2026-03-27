<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

    $result = $this->authService->login($credentials);

    return response()->json($result, $result['code'] ?? 200);

    }



}
