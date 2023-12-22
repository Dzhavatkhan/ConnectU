<?php

namespace App\Http\Resources;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\User;
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
        $attachment = Attachment::where('post_id', $this->id)->get();
        $category = Category::join('posts_categories', 'categories.id', 'posts_categories.category_id')
        ->where('posts_categories.post_id', $this->post_id)
        ->count();

        return [
            "id" => $this->id,
            "author" => $user->name,
            "text" => $this->text,
            "attachment" => $attachment,
            "category" => $category
        ];
    }
}
