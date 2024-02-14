<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\LoginRequest;
use App\Http\Requests\UserRequests\ReqisterRequest;
use App\Models\User;
use App\Models\User_category;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(ReqisterRequest $request) {
        try {

            $categories = explode(",", $request->categoryId);
            $user = User::create([
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'login' => $request->get('login'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role_id' => 2
            ]);

            for ($category=0; $category < count($categories); $category++) {
                User_category::create([
                    'user_id' => $user->id,
                    'category_id' => $categories[$category]
                ]);
            }


            (new ImageService)->updateImage($user, $request, '/images/avatars/', 'store');

            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Smth went wrong in AuthController.register'
            ], 403);
        }
    }

    public function login(LoginRequest $request) {
        try {

            $user = User::with('chats')->where('login', $request->get('login'))->firstOrFail();

            if(!Hash::check($request->get('password'), $user->password)) {

                return response()->json([
                    'error_code' => 'password',
                    'error' => 'Password wrong! :(',
                    'message' => 'Error in AuthController.login'
                ], 403);

            } else {

                $token = $user->createToken('user_token')->plainTextToken;
                $password = Hash::needsRehash($user->password);
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'password' => $password
                ], 200);

            }

        } catch (\Exception $e) {

            if ($e instanceof ModelNotFoundException) {

                return response()->json([
                    'error_code' => 1,
                    'error' => $e->getMessage(),
                    'message' => 'Smth went wrong in AuthController.login'
                ], 403);

            } else {

                return response()->json([
                    'error' => $e->getMessage(),
                    'message' => 'Smth went wrong in AuthController.login'
                ], 403);

            }

        }
    }

    public function logout() {

        try {

            $user = User::findOrFail(Auth::id());

            $user->tokens()->delete();

            return response()->json('Выход выполнен!', 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Smth went wrong in AuthController.logout'
            ], 403);

        }

    }
}
