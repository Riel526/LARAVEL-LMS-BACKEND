<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facade\Hash;
use Illuminate\Validation\ValidationException;

class AuthService {

  public function login(array $data) {
    $user = User::where('username', $data['username'])->first();

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
        'role' => $user->role,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name
      ]
    ];
  }

}