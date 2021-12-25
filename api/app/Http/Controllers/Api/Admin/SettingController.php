<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingGroupModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $settingGroups = SettingGroupModel::query()
            ->orderBy('sort_order')
            ->with(['settings' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->get();

        $settingGroups->map(function ($g) {
            $g->settings->map(function ($s){
                if (isJson($s->value)) {
                    $s->value = json_decode($s->value, true);
                }
            });
        });


        return $settingGroups;
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $group) {
            if (@is_array(@$group['settings'])) {
                foreach ($group['settings'] as $settingData) {
                    $s = SettingModel::query()->where('id',$settingData['id'])->first();
                    if ($s) {
                        $s->value = $settingData['value'];
                        $s->sort_order = $settingData['sort_order'];
                        $s->save();
                    }
                }
            }
        }
        return res(__('messages.action_success'));
    }

}
