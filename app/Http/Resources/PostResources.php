<?php

namespace App\Http\Resources;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Like;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::findOrFail($this->user_id);

        $attachment = Attachment::where('post_id', $this->id)->pluck('name');
        $type_attachment = Attachment::where('post_id', $this->id)->pluck('type');

        $likes = Like::where('post_id', $this->id)->count();

        $day = date('d', strtotime($this->created_at));
        $month = date('F', strtotime($this->created_at));
        $year = date('Y', strtotime($this->created_at));
        ///////////////////////////////////////////////////////

        if ($month == "January") {
            $month = "января";
        }
        if ($month == "February") {
            $month = "февраля";
        }
        if ($month == "March") {
            $month = "марта";
        }
        if ($month == "April") {
            $month = "апреля";
        }
        if ($month == "May") {
            $month = "мая";
        }
        if ($month == "June") {
            $month = "июня";
        }
        if ($month == "July") {
            $month = "июля";
        }
        if ($month == "August") {
            $month = "августа";
        }
        if ($month == "September") {
            $month = "сентебря";
        }
        if ($month == "October") {
            $month = "октября";
        }
        if ($month == "November") {
            $month = "ноября";
        }
        if ($month == "December") {
            $month = "декабря";
        }


        ///////////////////////////////////////////////////////
        $current_year = date('Y');
        if ($year == $current_year) {
            $date = "$day $month";
            $cur_dat = new DateTime(date('d.m.Y H:i:s'));
            $post_date = new DateTime(date('d.m.Y H:i:s', strtotime($this->created_at)));
            $interval = $cur_dat->diff($post_date);

            if ($interval->format("%i") <60 ) {
                $interval = $interval->format("%i");
                $date = "$interval минут назад";
            }
            elseif ( $interval->format("%i") >60 && $interval->format("%h") <60 ) {
                $interval = $interval->format("%h");
                $date = "$interval часов назад";
            }
            elseif ($interval->format("%h") >60 && $interval->format("%d") <30) {
                $interval = $interval->format("%d");
                $date = "$interval дней назад";
            }
            elseif ($interval->format("%d") <30 && $interval->format("%m") <12) {
                $interval = $interval->format("%m");
                $date = "$interval месяцев назад";
            }


        }
        else{
            $date = "$day $month $year";
        }


        $category = Category::join('posts_categories', 'categories.id', 'posts_categories.category_id')
        ->where('posts_categories.post_id', $this->post_id)
        ->get();

        return [
            "id" => $this->id,
            "author" => $user->name,
            "avatar" => $user->image,
            "text" => $this->text,
            "attachment" => $attachment,
            "type" => $type_attachment,
            "category" => $category,
            "likes" => $likes,
            "created_at" => $date
        ];
    }
}
