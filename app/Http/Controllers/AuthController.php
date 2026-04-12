<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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

    public function register(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username|min:4',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'role' => 'required|in:student,teacher',
            'birth_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $response = $this->authService->register($validator->validated());

        return response()->json($response, 201);
    }



}
