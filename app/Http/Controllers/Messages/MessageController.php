<?php

namespace App\Http\Controllers\Messages;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chats\MessageRequest;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $message = Message::create($request->validated());
        broadcast(new MessageSent($message))->toOthers();
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MessageRequest $request, Message $message)
    {
        $message->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->foceDelete();
        return messageResponse();
    }
}
