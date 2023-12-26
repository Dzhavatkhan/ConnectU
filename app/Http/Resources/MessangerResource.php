<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\UserChats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MessangerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $msg_date = $this->created_at;
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
        $time = 1;
        $user = User::findOrFail($this->user_id);
        $findRecipient = UserChats::where('chat_id', $this->chat_id)
                        ->where("user_id", "<>", Auth::id())
                        ->first();
        $recipient_id = $findRecipient->user_id;
        $recipient_avatar = User::where('id', $recipient_id)->first()->image;
        $recipient_name = User::where('id', $recipient_id)->first()->name;
        $recipient_surname = User::where('id', $recipient_id)->first()->surname;
        if($recipient_avatar == null){
            $recipient_avatar = "default.jpg";
        }

        return [
            "id" => $this->id,
            "avatar" => $recipient_avatar,
            //user_id for checking in chat
            "chat_id" => $this->chat_id,
            "rec_id" => $recipient_id,
            "user_id" => $this->user_id,
            "recipient"   => "$recipient_name $recipient_surname",
            "message"   => $this->message,
            "status"   => $this->status,
            "time"   => $msg_time,
            "date" => $msg_date
        ];
    }
}
