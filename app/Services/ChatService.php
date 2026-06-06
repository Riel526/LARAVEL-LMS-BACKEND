<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ChatService {

  public function getChats() {
    return Message::with('user')->latest()->take(50)->get()->reverse()->values();
  }

  public function createMessage(array $data, $userId)
{
    return Message::create([
        'user_id' => $userId,
        'text'  => $data['text'],
    ]);
}
}