<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InformationResource;
use App\Models\InformationModel;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 50;
        if (is_numeric($request->per_page)) {
            if ($request->per_page <= 100) {
                $perPage = $request->per_page;
            }
        }
        $allowedSortBy = ['id', 'title', 'sort_order'];
        $allowedWhereColumns = ['id', 'title'];

        $informationQuery = InformationModel::query();

        foreach ($allowedWhereColumns as $allowedWhereColumn) {
            if (!empty(@$request[$allowedWhereColumn])) {
                $informationQuery->where($allowedWhereColumn, $request[$allowedWhereColumn]);
            }
        }
        if (!empty($request->q)) {
            $informationQuery->where('title', 'LIKE', "%{$request->q}%");
        }

        $hasSortBy = false;
        if (!empty($request->sort_by)) {
            if (in_array(ltrim($request->sort_by, '-'), $allowedSortBy)) {
                $hasSortBy = true;
                $sortOrder = 'asc';
                if (substr($request->sort_by, 0, 1) == '-') {
                    $sortOrder = 'desc';
                }
                $informationQuery->orderBy(str_replace('-','',$request->sort_by), $sortOrder);
            }
        }
        if (!$hasSortBy) {
            $informationQuery->orderBy('id', 'asc');
        }

        return InformationResource::collection($informationQuery->paginate($perPage));
    }

    public function show(Request $request, $id)
    {
        $i = InformationModel::query()->find($id);
        if ($i) {
            return new InformationResource($i);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'content' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'required|min:0|max:1',
            'meta_title' => 'required',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        try {
            InformationModel::query()->create($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'content' => 'nullable',
            'sort_order' => 'nullable|integer',
            'status' => 'required|min:0|max:1',
            'meta_title' => 'required',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        try {
            InformationModel::query()->where('id', $id)->update($data);
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
            foreach ($ids as $categoryId) {
                $q = InformationModel::query()->find($categoryId);
                if ($q) {
                    @$q->delete();
                    array_push($deletedIds, $categoryId);
                }
            }
            return $deletedIds;
        }
        return abort(404);
    }
}
