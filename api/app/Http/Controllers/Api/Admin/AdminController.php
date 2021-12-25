<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminResource;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 25;
        if (is_numeric($request->per_page)) {
            if ($request->per_page <= 100) {
                $perPage = $request->per_page;
            }
        }
        $allowedSortBy = ['id', 'email', 'name', 'surname'];
        $allowedSearchColumns = ['id', 'email', 'name', 'surname'];

        $usersQuery = AdminModel::query();

        if (!empty($request->q)) {
            $usersQuery->where(DB::raw("CONCAT(name, ' ', surname)"), 'LIKE', "%" . $request->q . "%")
                ->orWhere('email', 'LIKE', "%{$request->q}%");
        } else {
            foreach ($allowedSearchColumns as $allowedSearchColumn) {
                if (!empty(@$request[$allowedSearchColumn])) {
                    $usersQuery->where($allowedSearchColumn, $request[$allowedSearchColumn]);
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
                $usersQuery->orderBy(str_replace('-','',$request->sort_by), $sortOrder);
            }
        }

        if (!$hasSortBy) {
            $usersQuery->orderBy('id', 'asc');
        }

        return AdminResource::collection($usersQuery->paginate($perPage));
    }

    public function show($id)
    {
        $user = AdminModel::query()->find($id);
        if ($user) {
            return new AdminResource($user);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:admin,email',
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'required',
        ]);
        $data = $request->only( 'email', 'name', 'surname');
        $data['password'] = app('hash')->make($request->password);
        try {
            AdminModel::query()->create($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:admin,email,' . $id,
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'nullable',
        ]);
        $data = $request->only( 'email', 'name', 'surname');
        if ($request->has('password')) {
            $data['password'] = app('hash')->make($request->password);
        }
        try {
            AdminModel::query()->where('id', $id)->update($data);
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
        $authUser = Auth::guard(env('API_ADMIN_AUTH_GUARD'))->user();
        if (is_array($ids)) {
            foreach ($ids as $userId) {
                $user = AdminModel::query()->find($userId);
                if ($user) {
                    if ($user->id != $authUser->id) {
                        @$user->delete();
                        array_push($deletedIds, $userId);
                    } else {
                        return res(__('messages.action_fail'), false, 500);
                    }
                }
            }
            return $deletedIds;
        }
        return abort(404);
    }

}
