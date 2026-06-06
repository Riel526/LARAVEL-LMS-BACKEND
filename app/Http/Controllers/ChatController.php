<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Services\ChatService;
use App\Events\MessageSent;

class ChatController extends Controller
{
    /**
     * Fetch the recent chat history.
     */
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
       return $this->chatService->getChats();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'text' => 'required|string',
    ]);

    $message = $this->chatService->createMessage($validated, auth()->id());

    $message->load('user');
    
    broadcast(new MessageSent($message->toArray()))->toOthers();

    return $message;
    }
}