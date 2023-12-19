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
    public function store($id)
    {
        $auth = Auth::user()->id;
        $checkIsFriend = Friend::whereIn('user_id', ["$auth", "$id"])
        ->whereIn('recipient_id', ["$auth", "$id"])
        ->where("status", "Принята");
        $checkIsRequest = Friend::whereIn('user_id', ["$auth", "$id"])
        ->whereIn('recipient_id', ["$auth", "$id"])
        ->where("status", "Отправлена");

        if ($checkIsFriend->count() > 0) {
            return response()->json([
                "message" => "Данный пользователь уже у Вас в друзьях",
            ]);
        }
        if ($checkIsRequest->count() > 0) {
            return response()->json([
                "message" => "Заявка уже была отправлена"
            ]);
        }
        $new_friend = Friend::create([

            "user_id"      => $auth,
            "recipient_id" => $id,
            "status"       => "Отправлена"
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
        $checkIsReq = Friend::whereIn('recipient_id', ["$auth", "$id"])
        ->where('status', "Отправлена")
        ->count();
        // return response()->json([
        //     "user" => $user,
        //     "friends" => $friends,
        //     "isFriend" => $isFriend
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //данные нужно отвалидировать
        $data = $request->validate([
            "name",
            "login",
            "categories_id"
        ]);

        $update = User::where('id', $id)->update($data);
        if ($update) {
            return response()
            ->json([
                "update" => "Ваш профиль отредактирован"
            ])
            ->header("content-type", 'application/json');
        }


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
