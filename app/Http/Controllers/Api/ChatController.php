<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Models\Message;
use App\Models\Chat;
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
        $id = Auth::id();
        // $chats = Chat::query()
        // ->leftJoin("messages", 'Chats.id', 'messages.chat_id')
        // ->whereRaw("FIND_IN_SET($id, participants)")
        // ->selectRaw("Chats.name,Chats.id")
        // ->get()
        // ->first();
        // $messages = Message::query()
        // ->where("chat_id", $chats->id)
        // ->orderByDesc("messages.created_at")
        // ->selectRaw("messages.message, messages.created_at")
        // ->get()
        // ->first();

        $chats = ChatResource::collection(Chat::all());
        return response()->json([
            "chats" => [
                $chats
            ]
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
        $createChat = Chat::create([
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
        $chat = Chat::query()
        ->leftJoin("users",'Chats.participant_id' , 'users.id')
        ->where('Chats.id', $id)
        ->selectRaw("Chats.*, users.name AS 'participant'")
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
