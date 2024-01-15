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
            $friend = User::findOrFail($search->user_id);
            $check_status = Friend::where('user_id', $search->user_id)->first();
            $status = $check_status->status;

        }
        else{
           $friend =  User::findOrFail($search->recipient_id);
           $check_status = Friend::where('recipient_id', $search->recipient_id)->first();
           $status = $check_status->status;
        }
        $my_request = Friend::where('user_id', Auth::id())->where("status", "Отправлена")->get();
        $toMe = Friend::where('recipient_id', Auth::id())->where("status", "Отправлена")->get();
        // $friend = User::where("id", "!=", Auth::id())->get();
        return [
            "id" => $this->id,
            "recipient_id" => $this->recipient_id,
            "user_id" => $this->user_id,
            "avatar" => $friend->image,
            "friend" => $friend->name,
            "status" => $this->status,
            "me" => $toMe,
            "my" => $my_request
        ];
    }
}
