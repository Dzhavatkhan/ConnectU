<?php

namespace App\Http\Resources;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $msg = Message::where("chat_id", $this->id)->latest()->limit(1)->pluck('message');
        $msg_date = Message::where("chat_id", $this->id)->latest()->limit(1)->pluck('created_at');
        $user_name = [];

        $msgs = Message::all();

        for ($index = 0; $index < count($msgs); $index++) {
            $user_name[] = $msgs[$index]->user->name;
        }

        return [
            "id" => $this->id,
            "name" => $user_name,
            "messages" => $msg,
            "created_at" => $msg_date
        ];
    }
}
