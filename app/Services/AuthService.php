<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

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
    return DB::transaction(function() use ($data) {

      if (isset($data['username'])) {
        if ($data['role'] === 'student') {
          $user->student()->create([
              'lrn' => null,
              'grade_level' => null,
              'section' =>  null,
              'gwa' => 0,
              'is_active' => 1
          ]);
      } else if ($data['role'] === 'teacher') {
          $user->teacher()->create([
            'employee_id' => null,
            'department' => null,
            'specialization' => null,
            'is_active' => 1
          ]);
        }
      }

      if (!isset($data['username']) || empty($data['username'])) {
        $cleanLastName = str_replace(' ', '', strtolower($data['last_name']));
        $birthYear = Carbon::parse($data['birth_date'])->format('Y-m-d');
        $data['username'] = $cleanLastName . $birthYear;
      }

      $user = User::create([
      'username' => $data['username'],
      'email' => $data['email'],
      'password' => $data['password'] ?? 'default123',
      'birth_date' => $data['birth_date'],

      // Formatting names: Uppercase first letter, lowercase the rest
      'first_name' => ucWords(strToLower($data['first_name'])),
      'middle_name' => ($data['middle_name'] ?? null) ? ucWords(strToLower($data['middle_name'])) : null,
      'last_name' => ucWords(strToLower($data['last_name'])),
      'role' => $data['role']
    ]);

    return [
      'code' => 201,
      'message' => 'User Created Successfully',
      'user' => $user
    ];
    });
  }

}