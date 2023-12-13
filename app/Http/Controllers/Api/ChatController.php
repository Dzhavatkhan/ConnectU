<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Personal_chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // айди не настоящийЮ взял чисто для теста
        $id = Auth::id();
        $chats = Personal_chat::query()
        ->leftJoin("messages", 'personal_chats.id', 'messages.chat_id')
        ->leftJoin("users", 'messages.recipient_id', 'users.id')
        ->whereRaw("FIND_IN_SET($id, participants)")
        ->selectRaw("personal_chats.name,personal_chats.id, messages.message, users.name AS 'participant'")
        ->orderByDesc("messages.created_at")
        ->groupBy("personal_chats.id")
        ->get();
        // $recipient = Personal_chat::query()
        // ->join("messages", 'personal_chats.id', 'messages.chat_id')
        // ->join("users", 'messages.sender_id', 'users.id')
        // ->where('messages.sender_id', $id)
        // ->selectRaw("users.name AS 'recipient'")
        // ->get();
        return response()->json([
            "chats" => $chats
        ], 200)->header("Content-type","application/json");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function createChat($id)
    {
        $user = Auth::user();
        $chat_user = User::query()->where("id", $id)->first();
        $createChat = Personal_chat::create([
            "name" => "$user->name,$chat_user->name",
            "participants" => "$user->id,$chat_user->id"
        ]);
        return response()->json([
            "chat" => $createChat
        ])->header("Content-type", "application/json");
    }

    public function message(Request $request)
    {
        $data = $request->only([
            "recipient_id",
            "chat_id",
            "message",
        ]);
        $message = Message::create([
            "sender_id" => Auth::id(),
            "recipient_id" => $data['recipient_id'],
            "chat_id" => $data['chat_id'],
            "status" => "Отправлено",
            "message" => $data['message']
        ]);
        $msg = Message::query()
        ->leftJoin('users', 'messages.recipient_id', 'users.id')
        ->selectRaw("messages.*, users.name")
        ->where("messages.sender_id", Auth::id())
        ->get();
        return response()->json([
            "message" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // айди текущего пользователя (примерный)
        $user_id = 71;
        //получаем нужный чат
        $chat = Personal_chat::query()
        ->leftJoin("users",'personal_chats.participant_id' , 'users.id')
        ->where('personal_chats.id', $id)
        ->selectRaw("personal_chats.*, users.name AS 'participant'")
        ->get();

        return response()->json([
            "chat" => $chat
        ], 200)->header("Content-type","application/json");


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
