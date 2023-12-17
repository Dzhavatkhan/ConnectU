<?php

namespace App\Http\Resources;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $msg_date = Message::where("chat_id", $this->id)->first()->created_at;

        //work with date
        $msg_day = date('d', strtotime($msg_date));
        $msg_month = date('F', strtotime($msg_date));
        $msg_time = date('H:m', strtotime($msg_date));
        if ($msg_month == "January") {
            $msg_month = "января";
        }
        if ($msg_month == "February") {
            $msg_month = "февраля";
        }
        if ($msg_month == "March") {
            $msg_month = "марта";
        }
        if ($msg_month == "April") {
            $msg_month = "апреля";
        }
        if ($msg_month == "May") {
            $msg_month = "мая";
        }
        if ($msg_month == "June") {
            $msg_month = "июня";
        }
        if ($msg_month == "July") {
            $msg_month = "июля";
        }
        if ($msg_month == "August") {
            $msg_month = "августа";
        }
        if ($msg_month == "September") {
            $msg_month = "сентебря";
        }
        if ($msg_month == "October") {
            $msg_month = "октября";
        }
        if ($msg_month == "November") {
            $msg_month = "ноября";
        }
        if ($msg_month == "December") {
            $msg_month = "декабря";
        }

        $msg_date = "$msg_day $msg_month";


        $user = DB::table('users_chats')
        ->where('users_chats.chat_id', $this->id)
        ->where("users_chats.user_id", '!=', Auth::id())
        ->first();
        $user = $user->user_id;
        $user = User::findOrFail($user);
        $user = $user->name;
        $user_name = [];

        // $msgs = Message::all();

        // for ($index = 0; $index < count($msgs); $index++) {
        //     $user_name[] = $msgs[$index]->user->name;
        // }

        return [
            "id" => $this->id,
            "name" => $user,
            "messages" => $msg,
            "time" => $msg_time,
            "created_at" => $msg_date
        ];
    }
}
