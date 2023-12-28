<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResources;
use App\Models\Attachment;
use App\Models\Like;
use App\Models\Posts;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Random;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Posts::query()
        // ->join('likes', 'posts.id', 'likes.post_id')
        // ->join("users", "posts.user_id", "users.id")
        // ->selectRaw("posts.*, users.name as 'user'")
        // ->orderByDesc("posts.created_at")
        // ->get();
        $posts = PostResources::collection(Posts::orderByDesc('created_at')->get());
        if ($posts->count() == 0) {
            return response()->json([
                "posts" => "Постов нет"
            ], 404);
        }
        return response()->json([
            "posts" => $posts
        ], 201)->header("Content-type","application/json");

        // $posts
    }
    public function my()
    {
        // $posts = Posts::query()
        // ->join('likes', 'posts.id', 'likes.post_id')
        // ->join("users", "posts.user_id", "users.id")
        // ->where('posts.user_id', Auth::id())
        // ->selectRaw("posts.*, users.name as 'user'")
        // ->orderByDesc("posts.created_at")
        // ->get();
        $posts = PostResources::collection(Posts::where('user_id', Auth::id())->get());
        if ($posts->count() == 0) {
            return response()->json([
                "posts" => "Постов нет"
            ], 404);
        }
        return response()->json([
            "posts" => $posts
        ], 201)->header("Content-type","application/json");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


            try {
                $user_id = Auth::id();
                $attachment = $request->attachment;
                $category_id = $request->category_id;
                $post_content = $request->validate([
                    "text" => ["sometimes", "string"],
                    "link" => ['string', "sometimes", "active_url"],
                    "category_id" => ['string', 'required'],
                    "attachment" => ['image', 'mimes:png,jpg']
                ]);



                $post = Posts::create([
                    "user_id" => $user_id,
                    "text" => $post_content['text'],
                ]);
                if ($post) {
                    $post->categories()->attach($category_id);
                    if (isset($attachment)) {
                        (new ImageService)->updateImage($post, $request, '/images/posts/', 'store');
                        Attachment::create([
                            "post_id" => $post->id,
                            "name" => $attachment,
                            "type" => "photo"
                        ]);
                    }

                    if (isset($post_content['link'])) {
                        Attachment::create([
                            "post_id" => $post->id,
                            "name" => $post_content['link'],
                            "type" => "video"
                        ]);
                    }


                    return response()->json([
                        "post" => $post
                    ], 201);
                }
                } catch (\Exception $exception) {
                    return response()->json([
                        "message" => $exception->getMessage(),
                        "error" => "Error in PostController"
                    ], 201);
            }



    }
    public function like($id)
    {
        $user = Auth::user();
        $checkLike = Like::where('user_id', $user->id)
        ->where('post_id', $id)
        ->get();

        if ($checkLike == null) {
            $post_like = Like::create([
                "user_id" => $user->id,
                "post_id" => $id
            ]);
        }
        else{
            $checkLike->delete();
        }

        return response()->json([
            "post" => $post_like
        ])->header("Content-type", "application/json");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Posts::query()
        ->join('likes', 'posts.id', 'likes.post_id')
        ->join("users", "posts.user_id", "users.id")
        ->selectRaw("posts.*, users.name as 'user'")
        ->where("posts.id", $id)
        ->get();
        return response()->json([
            "post" => $post
        ], 200)->header("Content-type","application/json");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Posts::findOrFail($id);
        $post_img = Attachment::where("post_id", $post->id)
        ->where("type", "photo")
        ->first()->name;
        //примерно
        $attachments = $request->image;
        $link = $request->link;
        $upd_content = $request->validate([
            "text" => ['string', 'sometimes'],
            "link" => ['string', 'sometimes', "active_url"]
        ]);
            $update = $post->update([
                "text" => $upd_content['text'],
            ]);
            if (isset($attachments)) {
                if (file_exists(public_path("posts/". $post_img))) {
                    unlink(public_path("posts/". $post_img));
                    (new ImageService)->updateImage($post, $request, '/images/posts/', 'store');
                    $post->update([
                        "name" => $attachments,
                        "type" => "photo"

                    ]);
                }
        }






    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Attachment::where("post_id", $id)->delete();
        Like::where("post_id",$id)->delete();
        Posts::findOrFail($id)->categories()->detach();
        Posts::findOrFail($id)->delete();

        return response()->json([
            "post" => "post is delete."
        ], 200);
    }
}
