<?php

namespace App\Http\Resources;

use App\Models\Friend;
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
        $friends = Friend::query()->whereRaw("FIND_IN_SET($id,friends)")->where("status", "Принята")->count();
        $push = Friend::query()->whereRaw("FIND_IN_SET($id,friends)")->where("status", "Отправлена");
        return [
            'id' => $id,
            "email" => $this->email,
            "image" => $this->image,
            "login" => $this->login,
            'surname' => $this->surname,
            "name" => $this->name,
            "friends" => $friends,
            "push" => $push
        ];
    }
}
