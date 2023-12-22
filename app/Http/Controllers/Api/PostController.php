<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResources;
use App\Models\Like;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $posts = PostResources::collection(Posts::all());
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
        $posts = Posts::query()
        ->join('likes', 'posts.id', 'likes.post_id')
        ->join("users", "posts.user_id", "users.id")
        ->where('posts.user_id', Auth::id())
        ->selectRaw("posts.*, users.name as 'user'")
        ->orderByDesc("posts.created_at")
        ->get();
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
        $user_id = Auth::id();
        $post_content = $request->validate([
            "text" => ["sometimes", "string"],
        ]);
        $post = Posts::create([
            "user_id" => $user_id,
            "text" => $post_content['text'],
        ]);
        if ($post) {
            return response()->json([
                "post" => $post
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
        $upd_content = $request->validate([
            "text" => ['string', 'sometimes']
        ]);
        $update = $post->update([
            "text" => $upd_content['text']
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
