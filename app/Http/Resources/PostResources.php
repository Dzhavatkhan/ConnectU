<?php

namespace App\Http\Resources;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Like;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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

        $attachment = Attachment::where('post_id', $this->id)->selectRaw("name, type")->get();

        $likes = Like::where('post_id', $this->id)->count();

        $my_like = Like::where('post_id', $this->id)->where("user_id", Auth::id())->get();
        $likes = [
            "likes" => $likes,
            "my_like" => $my_like
        ];

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
            if ($interval->format("%h") < 1 && $interval->format("%d") < 1 && $interval->format("%m") < 1) {
                $interval = $interval->format("%i");
                $date = "$interval минут назад";
            }
            elseif ($interval->format("%h")> 0  && $interval->format("%d") == 0 ) {
                $interval = $interval->format("%h");
                $date = "$interval часов назад";
            }
            elseif ($interval->format("%d")> 0  && $interval->format("%m") == 0 ) {
                $interval = $interval->format("%d");
                $date = "$interval дней назад";
            }
            elseif ($interval->format("%m") >= 1 && $interval->format("%m") <12) {
                $interval = $interval->format("%m");
                $date = "$interval месяцев назад";
            }


        }
        else{
            $date = "$day $month $year";
        }


        $category = Category::join('posts_categories', 'categories.id', 'posts_categories.category_id')
        ->where('posts_categories.posts_id', $this->post_id)
        ->get();

        return [
            "id" => $this->id,
            "author" => $user->name." ".$user->surname,
            "avatar" => $user->image,
            "text" => $this->text,
            "attachment" => $attachment,
            "category" => $category,
            "likes" => $likes,
            "created_at" => $date
        ];
    }
}
