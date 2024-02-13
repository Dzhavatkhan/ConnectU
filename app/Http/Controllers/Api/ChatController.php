<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessangerResource;
use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use App\Models\UserChats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $chats = ChatResource::collection(
            Chat::query()
                ->leftJoin('user_chats', 'chats.id', 'user_chats.chat_id')
                ->where('user_chats.user_id', Auth::id())
                ->selectRaw("chats.id, user_chats.user_id AS 'user_id'")
                ->orderByDesc('chats.created_at')
                ->get()
        );
        return response()->json([
            "chats" => $chats

        ], 200)->header("Content-type", "application/json");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function write($id)
    {

        $user = Auth::user();
        $chats = UserChats::where('user_id', $user->id)->pluck("chat_id");

        for ($i=0; $i < count($chats); $i++) {
            $recipient = User::find($id);
            $chatWithMe = UserChats::where("chat_id", $chats[$i])
            ->where('user_id', $id)
            ->get();

            // $chatWithMe = ChatResource::collection($chatWithMe);
        }

        // return User::with('chats')->findOrFail($id)->chats->where('user_id', Auth::id());

    }




    public function message(Request $request, $id)
    {
        $recipient_id = $id;

        $user_id = Auth::id();
        $check = UserChats::where('user_chats.user_id', [$id])
            ->where('user_id', '!=', $user_id)
            ->first();
        $check = DB::select("SELECT *, COUNT(*) AS 'count'
        FROM   user_chats
        WHERE user_id IN ($id,$user_id)
        GROUP BY chat_id
        HAVING COUNT(*) > 1");

        if ($check) {
            $check = $check[0];
            $chat_id = $check->chat_id;
            if (isset($request->chat_id)) {
                $chat_id = $request->chat_id;
            }
            $data = $request->only([
                "message",
            ]);
            $message = Message::create([
                "user_id" => Auth::id(),
                "chat_id" => $chat_id,
                "status" => "Отправлено",
                "message" => $data['message']
            ]);
        } else {
            //i create chat in chats
            $createChat = Chat::create();
            $chat_id = $createChat->id;

            //i create chat in user_chats
            //here chat for auth user and his recipient-user
            $createChat = UserChats::create([
                "chat_id" => $chat_id,
                "user_id" => Auth::id()
            ]);
            //
            $createChat = UserChats::create([
                "chat_id" => $chat_id,
                "user_id" => $recipient_id
            ]);


            //is a message auth user

            $data = $request->only([
                "chat_id",
                "message",
            ]);
            $message = Message::create([
                "user_id" => Auth::id(),
                "chat_id" => $chat_id,
                "status" => "Отправлено",
                "message" => $data['message']
            ]);
        }

        $msg = Message::query()
            ->leftJoin('users', 'messages.user_id', 'users.id')
            ->selectRaw("messages.*, users.name")
            ->where("messages.user_id", Auth::id())
            ->orderByDesc('messages.created_at')
            ->get();
        return response()->json([
            "message" => $msg
            // "recipient" =>

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        //получаем нужный чат
        // $chat = Chat::query()
        //     ->selectRaw("chats.id, users.name, messages.message, messages.created_at, messages.status")
        //     ->leftJoin('user_chats', 'chats.id', 'user_chats.chat_id')
        //     ->leftJoin('messages', 'chats.id', 'messages.user_id')
        //     ->leftJoin('users', 'users.id', 'messages.user_id')
        //     ->where('messages.chat_id', $id)
        //     ->orderBy('messages.created_at')
        //     ->get();

        $chat = MessangerResource::collection(
            // Chat::query()
            // ->selectRaw("chats.id, users.name, messages.message, messages.created_at, messages.status")
            // ->leftJoin('user_chats', 'chats.id', 'user_chats.chat_id')
            // ->leftJoin('messages', 'chats.id', 'messages.user_id')
            // ->leftJoin('users', 'users.id', 'messages.user_id')
            // ->where('messages.chat_id', $id)
            // ->orderBy('messages.created_at')
            Message::query()
                // ->join('chats', 'messages.chat_id', 'chats.id')
                // ->join("user_chats", "chats.id", "user_chats.chat_id")
                ->where('messages.chat_id', $id)
                ->distinct('messages.id')
                ->get()
        );

        return response()->json([
            "chat" => $chat
        ], 200)->header("Content-type", "application/json");
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
        $chat =  Message::where("id", $id)->first()->chat_id;
        $count_msg = Message::where("id", $id)->first()->chat_id;
        $count_msg_in_chat = Message::where("chat_id", $count_msg)->where("user_id", "!=", Auth::id())->count();
        $count_ur_msg_in_chat = Message::where("chat_id", $count_msg)->where("user_id", Auth::id())->count();      
        // $count_msg = Chat::where("id")
        $message = Message::findOrFail($id);
        $message->delete();
        if ($count_msg_in_chat == 0 && $count_ur_msg_in_chat == 1) {
            Chat::where("id", $chat)->delete();
            UserChats::where("chat_id", $chat)->delete();
        }
        return response()->json([
            "message" => "Сообщение удалено"
        ]);
    }
}
