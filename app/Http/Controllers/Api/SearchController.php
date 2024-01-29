<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use App\Models\UserChats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $users = UserResource::collection(User::where(DB::raw("concat(name,' ',surname)"), "like", "%" . $request->get('search') . "%")->where('id', '<>', Auth::id())->get());
        $findChats = DB::table('users')->where(DB::raw("concat(name,' ',surname)"), "like", "%" . $request->get('search') . "%")->where('id', '<>', Auth::id())
        ->pluck('id');
        $check_friend = 0;
        if ($findChats != null) {
        $findChats = $findChats[0];
        $findChats = UserChats::where('user_id', $findChats)
        ->where("user_id", "!=", $user->id)
        ->first();
        if ($findChats != null) {
            $chat_id = $findChats->chat_id;
            return response()->json([
                'users' => $users,
                'chat_id' => $chat_id
            ], 200);
        }
    }

        return response()->json(['users' => $users], 200);

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
        //
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
