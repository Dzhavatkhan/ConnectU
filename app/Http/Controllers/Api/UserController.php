<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use App\Http\Resources\FriendsResource;
use App\Http\Resources\UserResource;
use App\Models\Friend;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $user = UserResource::collection(User::with('friends')->where('id', $id)->get());
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

    public function friends(){
        return  FriendsResource::collection(Friend::where("user_id", Auth::id())->orWhere("recipient_id", Auth::id())->get());
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
        return UserResource::collection(User::where('id', $id)->get());
        // return response()->json([
        //     "user" => $user,
        //     "friends" => $friends,
        //     "isFriend" => $isFriend
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'login' => $request->get('login'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'image' => $request->file('email'),
        ];

        (new ImageService)->updateImage($user, $request, '/images/avatars/', 'store');
        // else{
        //     if (file_exists(storage_path('images/avatars/'.$user->image))) {
        //         $data['image'] = $user->image;
        //     }
        //     else{
        //         return response()->json([
        //             "message" => "Ваш аватар не найден"
        //         ], 404);
        //     }
        // }

        $update = User::where('id', $id)->update($data);
        $user->save();
        $user = User::findOrFail($id);

        if ($update) {
            return response()
            ->json([
                'user' => $user,
                "update" => "Ваш профиль отредактирован"
            ], 201)
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
