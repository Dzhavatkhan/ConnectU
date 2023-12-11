<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::query()
        ->join('likes', 'posts.id', 'likes.post_id')
        ->join("users", "posts.user_id", "users.id")
        ->selectRaw("posts.*, users.name as 'user', likes.quantity AS 'like'")
        ->get();
        return response()->json([
            "posts" => $posts
        ], 200)->header("Content-type","application/json");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function like(Request $request, $id)
    {
        $user_id = 71;
        $post_like = Like::query()
        ->where("post_id", $id)
        ->where("user_id", $user_id)
        ->first();

        if ($post_like->quantity = 0 || $post_like->quantity == null ) {
            Like::create([
                "user_id" => $user_id,
                "post_id" => $id,
                "quantity" => 1
            ]);
        }
        else{
            $like = $post_like->like;
            $like = $like - 1;
            $post_like = Like::query()
            ->where("post_id", $id)
            ->where("user_id", $user_id)
            ->update(["quantity" => $like]);
        }
    
        return response()->json([
            "like" => "have"
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
        ->selectRaw("posts.*, users.name as 'user', likes.quantity AS 'like'")
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
