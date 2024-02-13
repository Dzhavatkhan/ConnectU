<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\postreq;
use App\Http\Resources\PostResources;
use App\Models\Attachment;
use App\Models\Like;
use App\Models\Posts;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $posts = PostResources::collection(Posts::where('user_id', Auth::id())->orderByDesc("created_at")->get());
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
    public function store(postreq $request)
    {
        try {
            $user_id = Auth::id();
            // dd($request->file('attachment0'));

            // $attachment =
            // $attachment = "$attachment".".".$attachment->extension();
            $category_id = $request->category_id;

            $link = $request->get('link');

            $post = Posts::create([
                "user_id" => $user_id,
                "text" => $request->get('text'),
            ]);

            if ($post) {

                    $category_arr = $request->category_id;
                    $category_arr = explode(',', $category_arr);
                    for ($category = 0; $category < count($category_arr); $category++) {
                        // dd($category_arr[$category]);
                        $post->categories()->attach($category_arr[$category]);

                    }
                    // $created_cat = DB::table("posts_categories")->insert([
                    //     "posts_id" => $post->id,
                    //     "category_id" => $category
                    // ]);

                    // if ($created_cat == false) {
                        // $post->categories()->attach($category);
                    // }

                    }




                $attachments = $request->file('attachment0');
                if (isset($attachments)) {
                    for ($index = 0; $request->file('attachment' . $index); $index++) {
                        $attachment = $request->file('attachment' . $index);
                        $attachment = $attachment->getClientOriginalName();

                        $request->file('attachment'. $index)->move(public_path('images/attachments/'), $attachment);
                        Attachment::create([
                            "post_id" => $post->id,
                            "name" => $attachment,
                            "type" => "photo"
                        ]);

                    }
                    // (new ImageService)->updateImage($post, $request, '/images/attachments/', 'store');
                }

                $videos = explode(",", $request->videos);
                if (isset($videos)) {
                    for ($index = 0; $index < count($videos); $index++) {
                        Attachment::create([
                            "post_id" => $post->id,
                            "name" => $videos[$index],
                            "type" => "video"
                        ]);
                    }
                }

                // if (isset($link)) {
                //     Attachment::create([
                //         "post_id" => $post->id,
                //         "name" => $link,
                //         "type" => "video"
                //     ]);
                // }


                return response()->json([
                    "post" => $post,
                    "attachments" => $attachments
                ], 201);
        }
        catch (\Exception $exception) {
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
        ->count();
        if ($checkLike == null) {
            $post_like = Like::create([
                "user_id" => $user->id,
                "post_id" => $id
            ]);
            if (!$post_like) {
                return response()->json([
                    "message" => "error"
                ]);
            }
        }
        else{
            Like::where('user_id', $user->id)
            ->where('post_id', $id)
            ->first()
            ->delete();
        }
        return response()->json([
            "message" => "like"
        ]);
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

        $categories = explode(",", $request->categoryId);

        $checking_attachs = Attachment::where('post_id', $post->id)->count();
        // $originAttachments = explode(",", $request->originAttachments);
        $attachments = $request->file('attachment0');
        if (isset($attachments)) {
            if ($checking_attachs == null) {
                for ($index = 0; $request->file('attachment' . $index); $index++) {
                    $attachment = $request->file('attachment' . $index);
                    $attachment = $attachment->getClientOriginalName();

                    $request->file('attachment'. $index)->move(public_path('images/attachments/'), $attachment);
                    Attachment::create([
                        "post_id" => $post->id,
                        "name" => $attachment,
                        "type" => "photo"
                    ]);

                }
            } else {

                $deleteImages = explode(",", $request->deleteImages);
                // dd($deleteAttachments);
                if (isset($deleteImages)) {
                    for ($i=0; $i < count($deleteImages); $i++) {
                        Attachment::where("post_id", $id)->where("name", $deleteImages[$i])->delete();
                    }
                }

                for ($index = 0; $request->file('attachment' . $index); $index++) {
                    $attachment = $request->file('attachment' . $index);
                    $attachment = $attachment->getClientOriginalName();

                    $request->file('attachment'. $index)->move(public_path('images/attachments/'), $attachment);
                    Attachment::create([
                        "post_id" => $post->id,
                        "name" => $attachment,
                        "type" => "photo"
                    ]);

                }
            }

            // (new ImageService)->updateImage($post, $request, '/images/attachments/', 'store');


        }

        $deleteImages = explode(",", $request->deleteImages);
        // dd($deleteAttachments);
        if (isset($deleteImages)) {
            for ($i=0; $i < count($deleteImages); $i++) {
                Attachment::where("post_id", $id)->where("name", $deleteImages[$i])->delete();
            }
        }


        $videos = explode(",", $request->videos);
        if (isset($videos)) {
            if ($checking_attachs == null) {
                for ($index = 0; $index < count($videos); $index++) {
                    Attachment::create([
                        "post_id" => $post->id,
                        "name" => $videos[$index],
                        "type" => "video"
                    ]);
                }
            } else {
                Attachment::where("post_id", $id)->where("type", 'video')->delete();

                for ($index = 0; $index < count($videos); $index++) {
                    Attachment::create([
                        "post_id" => $post->id,
                        "name" => $videos[$index],
                        "type" => "video"
                    ]);
                }
            }
        }

        $data = [
            'text' => $request->get('text'),
        ];

        // if ($request->file('image')) {
        //     (new ImageService)->updateImage($post, $request, '/images/avatars/', 'store');
        // }

        $update = Posts::where('id', $id)->update($data);

        $post->save();
        $post = Posts::findOrFail($id);

        if ($update) {
            // $checking_attachs = Attachment::where('post_id', $post->id)->count();
            // if ($checking_attachs == null) {
            //         (new ImageService)->updateImage($post, $request, '/images/attachments/', 'store', true);

            //         // DB::insert('insert into attachments (post_id, name, type) values (?, ?, ?)', [$id, $attachments[$attach], 'photo']);
            //         // DB::table('posts_categories')->create([
            //         //     'posts_id' => $id,
            //         //     'category_id' => $categories[$category]
            //         // ]);
            // }
            // else {
            //     Attachment::where("post_id", $id)->delete();

            //         (new ImageService)->updateImage($post, $request, '/images/attachments/', 'store', true);

            //         // DB::insert('insert into attachments (post_id, name, type) values (?, ?, ?)', [$id, $attachments[$attach], 'photo']);

            //         // DB::table('posts_categories')->create([
            //         //     'posts_id' => $id,
            //         //     'category_id' => $categories[$category]
            //         // ]);
            // }



            $checking_cat = DB::table('posts_categories')->where('posts_id', $post->id)->count();
            if ($checking_cat == null) {
                for ($category=0; $category < count($categories); $category++) {
                    DB::insert('insert into posts_categories (posts_id, category_id) values (?, ?)', [$id, $categories[$category]]);
                    // DB::table('posts_categories')->create([
                    //     'posts_id' => $id,
                    //     'category_id' => $categories[$category]
                    // ]);
                }
            }
            else {
                DB::table('posts_categories')->where("posts_id", $id)->delete();

                for ($category=0; $category < count($categories); $category++) {
                    DB::insert('insert into posts_categories (posts_id, category_id) values (?, ?)', [$id, $categories[$category]]);

                    // DB::table('posts_categories')->create([
                    //     'posts_id' => $id,
                    //     'category_id' => $categories[$category]
                    // ]);
                }
            }
            $post = Posts::with("categories")->findOrFail($id);
            return response()
            ->json([
                'user' => $post,
                "update" => "Ваш профиль отредактирован"
            ], 201)
            ->header("content-type", 'application/json');
        }
        // $post_img = Attachment::where("post_id", $post->id)
        // ->where("type", "photo")
        // ->first()->name;
        // //примерно
        // $attachments = $request->image;
        // $link = $request->link;
        // $upd_content = $request->validate([
        //     "text" => ['string', 'sometimes'],
        //     "link" => ['string', 'sometimes', "active_url"]
        // ]);
        //     $update = $post->update([
        //         "text" => $upd_content['text'],
        //     ]);
        //     if (isset($attachments)) {
        //         if (file_exists(public_path("posts/". $post_img))) {
        //             unlink(public_path("posts/". $post_img));
        //             (new ImageService)->updateImage($post, $request, '/images/posts/', 'store');
        //             $post->update([
        //                 "name" => $attachments,
        //                 "type" => "photo"

        //         ]);
        //     }
        // }
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
