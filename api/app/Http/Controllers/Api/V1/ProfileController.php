<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProfileResource;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return new ProfileResource($user);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'email' => 'required|email|unique:user,email,' . $user->id,
            'name' => 'required',
            'surname' => 'required',
            'password' => 'nullable',
        ]);
        $data = $request->only(['email', 'name', 'surname']);
        if (!empty($request->password)) {
            $data['password'] = app('hash')->make($request->password);
        }

        $u = UserModel::query()->where('id', $user->id)->first();
        if ($u) {
            $u->update($data);
            return res(__('messages.action_success'), [
                'user' => new ProfileResource($u),
            ]);
        }
        return res(__('messages.action_fail'), false, 500);
    }
}
