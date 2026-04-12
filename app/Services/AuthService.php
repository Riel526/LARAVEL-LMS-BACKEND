<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService {

  public function login(array $data) {
    $user = User::where('username', $data['username'])->orWhere('email', $data['username'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      throw ValidationException::withMessages([
        'username' => ['The credentials provided is incorrect.']
      ]);
    }

    $token = $user->createToken('eden-access-token')->plainTextToken;

    return [
      'status' => 'success',
      'code' => 200,
      'data' => [
        'user' => $user,
        'token' => $token,
      ]
    ];
  }

  public function register(array $data) {
    $user = User::create([
      'username' => $data['username'],
      'email' => $data['email'],
      'password' => $data['password'],
      'birth_date' => $data['birth_date'],

      // Formatting names: Uppercase first letter, lowercase the rest
      'first_name' => ucWords(strToLower($data['first_name'])),
      'middle_name' => ($data['middle_name'] ?? null) ? ucWords(strToLower($data['middle_name'])) : null,
      'last_name' => ucWords(strToLower($data['last_name'])),
      'role' => $data['role']
    ]);

    return [
      'code' => 201,
      'message' => 'User Created Successfully'
    ];
  }

}