<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\ProfileResource;
use App\Http\Resources\V1\SettingGroupResource;
use App\Models\CategoryModel;
use App\Models\SettingGroupModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitController extends Controller
{
    public function index(Request $request)
    {
        $settingGroups = SettingGroupModel::query()
            ->where('key', 'site')
            ->orwhere('key', 'general')
            ->with('settings')
            ->get();

        $settings = [];
        foreach ($settingGroups as $settingGroup) {
            foreach ($settingGroup->settings as $setting) {
                $settings[$settingGroup->key . '.' . $setting->key] = $setting->value;
            }
        }

        $categoryQuery = CategoryModel::query()->where('parent_id', null)->orderBy('sort_order');
        $categories = CategoryResource::collection($categoryQuery->get());

        $authUser = Auth::user();
        $user = false;
        $auth = false;
        if ($authUser) {
            $user = new ProfileResource($authUser);
            $auth = true;
        }

        return [
            'settings' => $settings,
            'categories' => $categories,
            'user' => $user,
            'auth' => $auth,
        ];
    }
}
