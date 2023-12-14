<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $msg = Message::where("chat_id", $this->id)->latest()->limit(1)->pluck('message');
        $msg_date = Message::where("chat_id", $this->id)->latest()->limit(1)->pluck('created_at');
        return [
            "id" => $this->id,
            "name" => $this->name,
            "messages" => $msg,
            "created_at" => $msg_date
        ];
    }
}
