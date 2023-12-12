<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personal_chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // айди не настоящийЮ взял чисто для теста
        $id = 83;
        $chats = Personal_chat::query()
        ->distinct()
        ->join("messages", 'personal_chats.id', 'messages.chat_id')
        ->join("users", 'messages.sender_id', 'users.id')
        ->whereRaw("FIND_IN_SET($id, participants)")
        ->selectRaw("personal_chats.name,personal_chats.id, messages.message, users.name AS 'participant'")
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
