<?php

namespace App\Http\Controllers\Chats;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chats\ChatRequest;
use App\Http\Requests\Chats\MessageRequest;
use App\Jobs\SendNotification;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chats = Chat::query()->when($request->branch_id, function ($query) use ($request) {
            $query->where('branch_id', $request->branch_id);
        })->when($request->user_id, function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->with(['messages' => function ($query) {
            $query->latest()->limit(1);
        }])->latest()->get();

        if ($request->has('user_id')) {
            $chats->transform(function ($chat) {
                $chat->user = $chat->branch->user;
                return $chat;
            });
        }
        if ($request->has('branch_id')) {
            $chats->transform(function ($chat) {
                $chat->user = $chat->user;
                return $chat;
            });
        }

        // Unset the branch relationship for each chat
        $chats->each(function ($chat) {
            unset($chat->branch);
        });

        return contentResponse($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatRequest $request)
    {
        $chat = Chat::firstOrCreate($request->safe()->only(['branch_id', 'user_id']));
        return contentResponse(['chat_id' => $chat->id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMessage(MessageRequest $request)
    {
        $message = Message::create($request->validated());
        broadcast(new MessageSent($message))->toOthers();
        $userId1 = $message->chat->branch->manager;
        $userId2 = $message->chat->user;
        if ($message->sender_id == $userId1) {
            $user = $userId1;
        } else {
            $user = $userId2;
        }
        SendNotification::dispatch($message->chat, 'chats', $user->name, $message->message, $user->id);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return contentResponse($chat->load('user', 'messages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        $chat->forceDelete();
        return messageResponse();
    }
}
