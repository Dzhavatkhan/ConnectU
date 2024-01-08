<?php

namespace App\Http\Resources;

use App\Models\Friend;
use App\Models\User;
use App\Models\User_category;
use App\Models\UserChats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
        $counts = DB::select("SELECT COUNT(*) as 'friends' FROM `friends` WHERE (user_id = $id OR user_id = $id) AND status = 'Принята';");
        foreach ($counts as $friend_count) {
            $friend_count = $friend_count->friends;
        }
        $push = Friend::query()->where("recipient_id", $id)->where("status", "Отправлена")->latest();
        if ($push->count() > 0) {

            $user_id = $push->pluck('user_id');
            for ($i=0; $i < count($user_id); $i++) {
                $requester = User::where('id', $user_id[$i])->first()->name;
                $push = "$requester хочет добавить Вас в друзья!";            }

        }
        $category = User_category::where("user_id", $this->id)->pluck("name");

        return [
            'id' => $id,
            "email" => $this->email,
            "image" => $this->image,
            "login" => $this->login,
            'surname' => $this->surname,
            "name" => $this->name,
            "password" => bcrypt($this->password),
            "category" => $category,
            "friends" => $friend_count,
            "chats" => $this->chats->count(),
            "push" => $push
        ];
    }
}
