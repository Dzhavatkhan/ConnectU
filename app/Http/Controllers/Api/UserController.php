<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $user = Auth::user();
        return response()->json([
            "profile" => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth = 71;
        $user_id = $request->user_id;
        Friend::create([
            "friends" => "$auth,$user_id"
        ]);
        return response()->json([
            "addFriend" => "Добавлен в друзья"
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
        $auth = 71;
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
    public function destroy(string $id)
    {
        //
    }
}
