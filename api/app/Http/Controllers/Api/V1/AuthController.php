<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProfileResource;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user',
            'password' => 'required',
        ]);
        $data = [
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
        ];
        $user = UserModel::query()->create($data);
        if ($user) {
            return res(__('messages.register_successful'), ['user' => ['email' => $user->email]]);
        }
        return res(__('messages.action_fail'));
    }


    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $token = Auth::attempt($credentials);

        if (!$token) {
            return res(__('messages.wrong_credentials'), false, 422);
        }

        $user = Auth::user();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => new ProfileResource($user),
            'message' => __('messages.auth_success'),
            'expires_in' => config('jwt.ttl')
        ], 200);
    }

    public function logout()
    {
        try {
            Auth::guard(env('auth_guard'))->logout();
            return res(__('messages.logout_success'), false, 200);
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function check()
    {
        $check = Auth::check();
        $user = Auth::user();
        if ($check && $user) {
            return res(__('messages.authenticated'), ['user' => new ProfileResource($user)], 200);
        }
        return res(__('messages.not_authenticated'), false, 401);
    }



}
