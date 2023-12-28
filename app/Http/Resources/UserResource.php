<?php

namespace App\Http\Resources;

use App\Models\Friend;
use App\Models\User;
use App\Models\UserChats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $id = $this->id;
        $friend_count = Friend::query()->where('user_id', $id)->orWhere("recipient_id", $id)->where("status", "Принята")->count();

        $push = Friend::query()->where("recipient_id", $id)->where("status", "Отправлена")->latest();
        if ($push->count() > 0) {

            $user_id = $push->pluck('user_id');
            for ($i=0; $i < count($user_id); $i++) {
                $requester = User::where('id', $user_id[$i])->first()->name;
                $push = "$requester хочет добавить Вас в друзья!";            }

        }
        
        return [
            'id' => $id,
            "email" => $this->email,
            "image" => $this->image,
            "login" => $this->login,
            'surname' => $this->surname,
            "name" => $this->name,
            "friends" => $this->friends,
            "chats" => $this->chats->count(),
            "push" => $push
        ];
    }
}
