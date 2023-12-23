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
        }
        else{
           $friend =  User::findOrFail($search->recipient_id);
        }
        // $friend = User::where("id", "!=", Auth::id())->get();
        return [
            "id" => $this->id,
            "avatar" => $this->image,
            "friend" => $friend->name
        ];
    }
}
