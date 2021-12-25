<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::guard(env('API_ADMIN_AUTH_GUARD'))->attempt($credentials);
        if ($token) {
            $user = new ProfileResource(Auth::guard(env('API_ADMIN_AUTH_GUARD'))->user());
            return $this->respondWithToken($token, $user);
        }
        return res(__('messages.wrong_credentials'), false, 422);
    }

    public function check()
    {
        $user = Auth::guard(env('API_ADMIN_AUTH_GUARD'))->user();
        if ($user) {
            return res(__('messages.authenticated'), ['user' => new ProfileResource($user)]);
        }
        return res(__('messages.unauthorized'), false, 422);
    }

    public function logout()
    {
        try {
            Auth::guard(env('API_ADMIN_AUTH_GUARD'))->logout();
        } catch (\Exception $e) {

        }
        return true;
    }

    public function respondWithToken($token, $user = null)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'message' => __('messages.auth_success'),
            'expires_in' => config('jwt.ttl')
        ], 200);
    }


}
