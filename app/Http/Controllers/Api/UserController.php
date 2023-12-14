<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $user = UserResource::collection(User::where('id', $id)->get());
        return response()->json([
            "profile" => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth = Auth::id();
        $user_id = $request->user_id;
        $new_friend = User::where("id", $user_id)->first();
        Friend::create([
            "friends" => "$auth,$user_id",
            "status" => "Отправлена"
        ]);
        return response()->json([
            "message" => "Заявка отправлена"
        ]);
    }
    public function search( Request $request)
    {
        $query = $request->search;
        if (empty($request->search) || !isset($request->search)) {
            return response()->json([
                "result" => 0
            ]);
        }
        else{


        $result = User::query()
        ->where("name", "Like", "%$query%")->get();
        return response()->json([
            "result" => $result
        ], 200);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $auth = Auth::user()->id;
        $user = User::query()->where("id", $id)->get();
        $friends = Friend::query()
        ->whereRaw("FIND_IN_SET($id, friends)");

        if($friends == null){
            $friends = 0;
        }
        else{
            $friends = $friends->count();

        }
        if (Friend::query()
            ->whereRaw("FIND_IN_SET($id, friends)")
            ->whereRaw("FIND_IN_SET($auth, friends)")
            ->count() > 0
        ) {
            $isFriend = 1;
        }
        else{
            $isFriend = 0;
        }
        return response()->json([
            "user" => $user,
            "friends" => $friends,
            "isFriend" => $isFriend
        ]);
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
    public function destroy()
    {
        $delete = User::query()->where('id', Auth::id())->delete();
        if ($delete) {
            return response()->json([
                "message" => "Вы удалены"
            ], 200);
        }
        else{
            return response()->json([
                "message" => "Не удалость удалить свой аккаунт"
            ], 200);
        }
    }
}
