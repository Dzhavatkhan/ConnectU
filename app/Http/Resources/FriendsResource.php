<?php

namespace App\Http\Resources;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FriendsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $search = Friend::where('id', $this->id)->first();
        if ($search->recipient_id == Auth::id()) {
            $friend = User::leftJoin('friends', "users.id", "friends.user_id")
                ->where("friends.user_id", $search->user_id)
                ->where("friends.status", "Принята")
                ->selectRaw("users.name AS 'name', users.image AS 'avatar', users.surname AS 'surname'")
                ->get();
        }
        else{
            $friend = User::leftJoin('friends', "users.id", "friends.recipient_id")
                ->where("friends.recipient_id", $search->recipient_id)
                ->where("friends.status", "Принята")
                ->selectRaw("users.name AS 'name', users.image AS 'avatar', users.surname AS 'surname'")
                ->get();
            }
        $my_request = Friend::leftJoin("users", "friends.recipient_id", "users.id")
            ->where('user_id', Auth::id())
            ->where("status", "Отправлена")
            ->selectRaw("friends.id AS 'id', users.id AS 'friend_id', users.image AS 'avatar', users.name AS 'name', users.surname AS 'surname'")
            ->get();
        $toMe = Friend::leftJoin("users", "friends.user_id", "users.id")
            ->where('recipient_id', Auth::id())
            ->where("status", "Отправлена")
            ->selectRaw("friends.id AS 'id', users.id AS 'friend_id', users.image AS 'avatar', users.name AS 'name', users.surname AS 'surname'")
            ->get();
        // $friend = User::where("id", "!=", Auth::id())->get();
        return [
            "id" => $this->id,
            "recipient_id" => $this->recipient_id,
            "user_id" => $this->user_id,
            "friend" => $friend,
            "status" => $this->status,
            "me" => $toMe,
            "my" => $my_request
        ];
    }
}
