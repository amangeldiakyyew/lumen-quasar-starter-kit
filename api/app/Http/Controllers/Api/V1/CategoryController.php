<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'per_page' => 'nullable|integer|min:1|max:200'
        ]);
        $perPage = $request->per_page ?? 50;
        $allowedOrderBy = ['name', 'sort_order'];
        $allowedWith = ['recursiveChildren', 'children', 'parent'];
        $allowedMutations = ['parent_name'];

        $categoryQuery = CategoryModel::query()->where('parent_id', null);

        if (!empty($request->q)) {
            $categoryQuery->where('name', 'LIKE', "%{$request->q}%");
        }

        if (!empty($request->sort_by)) {
            if (in_array(ltrim($request->sort_by, '-'), $allowedOrderBy)) {
                $sortOrder = 'asc';
                if (substr($request->sort_by, 0, 1) == '-') {
                    $sortOrder = 'desc';
                }
                $categoryQuery->orderBy($request->sort_by, $sortOrder);
            }
        }

        if (is_array($request->with)) {
            foreach ($request->with as $withName) {
                if (in_array($withName, $allowedWith)) {
                    $categoryQuery->with($withName);
                }
            }
        }


        return \App\Http\Resources\V1\CategoryResource::collection($categoryQuery->paginate($perPage));

    }
}
