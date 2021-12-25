<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
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

        $usersQuery = UserModel::query();

        if (!empty($request->q)) {
            $usersQuery->where(DB::raw("CONCAT(name, ' ', surname)"), 'LIKE', "%".$request->q."%")
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

        return UserResource::collection($usersQuery->paginate($perPage));
    }

    public function show($id)
    {
        $user = UserModel::query()->find($id);
        if ($user) {
            return new UserResource($user);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user,email',
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'required',
        ]);
        $data = $request->only('email', 'name', 'surname');
        $data['password'] = app('hash')->make($request->password);
        $data = array_map('trim', $data);

        try {
            UserModel::query()->create($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return $e;
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:user,email,' . $id,
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'nullable',
        ]);
        $data = $request->only('email', 'name', 'surname');
        $data = array_map('trim', $data);
        if ($request->has('password')) {
            $data['password'] = app('hash')->make($request->password);
        }
        try {
            UserModel::query()->where('id', $id)->update($data);
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
            foreach ($ids as $userId) {
                $user = UserModel::query()->find($userId);
                if ($user) {
                    @$user->delete();
                    array_push($deletedIds, $userId);
                }
            }
            return $deletedIds;
        }
        return abort(404);
    }

}
