<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 50;
        if (is_numeric($request->per_page)) {
            if ($request->per_page <= 100) {
                $perPage = $request->per_page;
            }
        }
        $allowedSortBy = ['id', 'name', 'price'];
        $allowedWhereColumns = ['id', 'name'];
        $allowedWith = ['recursiveChildren', 'children', 'parent'];

        $categoryQuery = CategoryModel::query();

        $hasWhere = false;
        foreach ($allowedWhereColumns as $allowedWhereColumn) {
            if (!empty(@$request[$allowedWhereColumn])) {
                $hasWhere = true;
                $categoryQuery->where($allowedWhereColumn, $request[$allowedWhereColumn]);
            }
        }
        if (!$hasWhere && empty($request->q)) {
            $categoryQuery->where('parent_id', '=', null);
        }

        if (!empty($request->q)) {
            $categoryQuery->where('name', 'LIKE', "%{$request->q}%");
        }


        $hasSortBy = false;
        if (!empty($request->sort_by)) {
            if (in_array(ltrim($request->sort_by, '-'), $allowedSortBy)) {
                $hasSortBy = true;
                $sortOrder = 'asc';
                if (substr($request->sort_by, 0, 1) == '-') {
                    $sortOrder = 'desc';
                }
                $categoryQuery->orderBy(str_replace('-', '', $request->sort_by), $sortOrder);
            }
        }
        if (!$hasSortBy) {
            $categoryQuery->orderBy('name', 'asc');
        }

        if (is_array($request->with)) {
            foreach ($request->with as $withName) {
                if (in_array($withName, $allowedWith)) {
                    $categoryQuery->with($withName);
                }
            }
        }

        $categories = $categoryQuery->paginate($perPage);


        return CategoryResource::collection($categories);
    }

    public function autocomplete(Request $request)
    {
        $perPage = 10;
        $allowedSearchColumns = ['name'];
        $allowedWith = ['recursiveChildren', 'children', 'parent'];

        if (is_numeric($request->per_page)) {
            if ($request->per_page <= 20) {
                $perPage = $request->per_page;
            }
        }

        $categoryQuery = CategoryModel::query();
        foreach ($allowedSearchColumns as $allowedSearchColumn) {
            if (!empty(@$request[$allowedSearchColumn])) {
                $categoryQuery->where($allowedSearchColumn, 'LIKE', "%{$request[$allowedSearchColumn]}%" );
            }
        }

        if (is_array($request->with)) {
            foreach ($request->with as $withName) {
                if (in_array($withName, $allowedWith)) {
                    $categoryQuery->with($withName);
                }
            }
        }

        $categories = $categoryQuery->orderBy('name','asc')->paginate($perPage);

        $categories->map(function ($category) {
            $category->name = trim($this->createName($category), '< ');
            return $category;
        });
        return CategoryResource::collection($categories);
    }

    public function show(Request $request, $id)
    {
        $allowedWith = ['recursiveChildren', 'children', 'parent'];

        $categoryQuery = CategoryModel::query()->where('id', $id);
        if (is_array($request->with)) {
            foreach ($request->with as $withName) {
                if (in_array($withName, $allowedWith)) {
                    $categoryQuery->with($withName);
                }
            }
        }
        $category = $categoryQuery->first();

        if ($category) {
            return new CategoryResource($category);
        }

        return abort(404);
    }

    public function createName($category)
    {
        $name = $category->name . ' < ';
        if ($category->parent) {
            $name .= ' ' . $this->createName($category->parent);
        }
        return $name;
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'parent_id' => 'nullable|exists:category,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required',
            'icon_class' => 'nullable',
            'meta_title' => 'required',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'sort_order' => 'nullable|integer',
            'product_addable' => 'required|min:0|max:1',
            'status' => 'nullable|min:0|max:1',
        ]);
        try {
            CategoryModel::query()->create($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'parent_id' => 'nullable|exists:category,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'icon_class' => 'nullable',
            'meta_title' => 'required',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'sort_order' => 'nullable|integer',
            'product_addable' => 'required|min:0|max:1',
            'status' => 'nullable|min:0|max:1',
        ]);
        try {
            CategoryModel::query()->where('id', $id)->update($data);
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
                $user = CategoryModel::query()->find($categoryId);
                if ($user) {
                    @$user->delete();
                    array_push($deletedIds, $categoryId);
                }
            }
            return $deletedIds;
        }
        return abort(404);
    }

}
