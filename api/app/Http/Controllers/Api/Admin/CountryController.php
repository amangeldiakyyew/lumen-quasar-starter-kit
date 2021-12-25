<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CountryResource;
use App\Models\CountryModel;
use Illuminate\Http\Request;

class CountryController extends Controller
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

        $countryQuery = CountryModel::query();

        foreach ($allowedWhereColumns as $allowedWhereColumn) {
            if (!empty(@$request[$allowedWhereColumn])) {
                $countryQuery->where($allowedWhereColumn, $request[$allowedWhereColumn]);
            }
        }
        if (!empty($request->q)) {
            $countryQuery->where('name', 'LIKE', "%{$request->q}%")
                ->orWhere('native', 'LIKE', "%{$request->q}%")
                ->orWhere('iso2', 'LIKE', "%{$request->q}%")
                ->orWhere('iso3', 'LIKE', "%{$request->q}%");
        }

        $hasSortBy = false;
        if (!empty($request->sort_by)) {
            if (in_array(ltrim($request->sort_by, '-'), $allowedSortBy)) {
                $hasSortBy = true;
                $sortOrder = 'asc';
                if (substr($request->sort_by, 0, 1) == '-') {
                    $sortOrder = 'desc';
                }
                $countryQuery->orderBy(str_replace('-','',$request->sort_by), $sortOrder);
            }
        }
        if (!$hasSortBy) {
            $countryQuery->orderBy('id', 'asc');
        }

        return CountryResource::collection($countryQuery->paginate($perPage));
    }

    public function show(Request $request, $id)
    {
        $c = CountryModel::query()->find($id);
        if ($c) {
            return new CountryResource($c);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'iso2' => 'required',
            'iso3' => 'required',
            'phone_code' => 'required',
            'currency' => 'required',
            'native' => 'required',
        ]);

        try {
            CountryModel::query()->create($data);
            return res(__('messages.action_success'));
        } catch (\Exception $e) {
            return res(__('messages.action_fail'), false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'iso2' => 'required',
            'iso3' => 'required',
            'phone_code' => 'required',
            'currency' => 'required',
            'native' => 'required',
        ]);

        try {
            CountryModel::query()->where('id', $id)->update($data);
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
            foreach ($ids as $wci) {
                $q = CountryModel::query()->find($wci);
                if ($q) {
                    @$q->delete();
                    array_push($deletedIds, $wci);
                }
            }
            return $deletedIds;
        }
        return abort(404);
    }
}
