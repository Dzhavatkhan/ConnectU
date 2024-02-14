<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResources;
use App\Models\Category;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $postsId = DB::table('posts_categories')->where('category_id', $id)->pluck('posts_id');
        // // dd($postsWithCategories);
        // $posts = [];
        // for ($i = 0; $i < count($postsId); $i++) {
        //     $posts[] = PostResources::collection(Posts::where('id', $postsId[$i])->orderByDesc('created_at')->get());
        // }

        $posts = PostResources::collection(DB::table('posts_categories')->where('category_id', $id)->join('posts', 'posts.id', 'posts_categories.posts_id')->get());

        // $posts = PostResources::collection(Posts::where('')->orderByDesc('created_at')->get());
        if (count($posts) == 0) {
            return response()->json([
                "posts" => "Постов нет"
            ], 404);
        }
        return response()->json([
            "posts" => $posts
        ], 201)->header("Content-type","application/json");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
