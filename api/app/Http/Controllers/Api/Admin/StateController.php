<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\StateResource;
use App\Models\StateModel;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 50;
        if (is_numeric($request->per_page)) {
            if ($request->per_page <= 100) {
                $perPage = $request->per_page;
            }
        }
        $allowedSortBy = ['id', 'name'];
        $allowedWhereColumns = ['id', 'name'];
        $allowedWith = ['country'];

        $stateQuery = StateModel::query();

        foreach ($allowedWhereColumns as $allowedWhereColumn) {
            if (!empty(@$request[$allowedWhereColumn])) {
                $stateQuery->where($allowedWhereColumn, $request[$allowedWhereColumn]);
            }
        }
        if (!empty($request->q)) {
            $stateQuery->where('name', 'LIKE', "%{$request->q}%");
        }

        if (is_array($request->with)) {
            foreach ($request->with as $withName) {
                if (in_array($withName, $allowedWith)) {
                    $stateQuery->with($withName);
                }
            }
        }

        $hasSortBy = false;
        if (!empty($request->sort_by)) {
            if (in_array(ltrim($request->sort_by, '-'), $allowedSortBy)) {
                $hasSortBy = true;
                $sortOrder = 'asc';
                if (substr($request->sort_by, 0, 1) == '-') {
                    $sortOrder = 'desc';
                }
                $stateQuery->orderBy(str_replace('-', '', $request->sort_by), $sortOrder);
            }
        }
        if (!$hasSortBy) {
            $stateQuery->orderBy('id', 'asc');
        }

        return StateResource::collection($stateQuery->paginate($perPage));
    }

    public function show(Request $request, $id)
    {
        $allowedWith = ['country'];

        $stateQuery = StateModel::query()->where('id',$id);
        if (is_array($request->with)) {
            foreach ($request->with as $withName) {
                if (in_array($withName, $allowedWith)) {
                    $stateQuery->with($withName);
                }
            }
        }
        $state=$stateQuery->first();
        if ($state) {
            return new StateResource($state);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'country_id' => 'required|exists:country,id',
            'country_code' => 'nullable',
            'iso2' => 'nullable',
        ]);

        try {
            StateModel::query()->create($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'country_id' => 'required|exists:country,id',
            'country_code' => 'nullable',
            'iso2' => 'nullable',
        ]);

        try {
            StateModel::query()->where('id', $id)->update($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function delete(Request $request, $id = null)
    {
        $ids = [];
        $deletedIds = [];
        if ($id == null) {
            $this->validate($request, [
                'ids' => 'required',
            ]);
            $ids = $request->ids;
        } else {
            $ids = [$id];
        }
        if (is_array($ids)) {
            foreach ($ids as $wsi) {
                $q = StateModel::query()->find($wsi);
                if ($q) {
                    @$q->delete();
                    array_push($deletedIds, $wsi);
                }
            }
            return $deletedIds;
        }
        return abort(404);
    }
}
