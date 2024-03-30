<?php

namespace App\Http\Controllers;

use App\Models\Districts;
use App\Models\Wards;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function stateByCountry($id)
    {
        $states = Districts::where(['province_code' => $id])->orderBy('name', 'asc')->get();
        $response = '<option value="">Chọn quận/huyện</option>';
        if ($states->count() > 0) {
            foreach ($states as $state) {
                $response .= "<option value=" . $state->code . ">" . $state->name . "</option>";
            }
        }

        return response()->json(['states' => $response]);
    }

    public function cityByState($id)
    {
        $cities = Wards::where(['district_code' => $id])->orderBy('name', 'asc')->get();
        $response = '<option value="">Chọn phường/xã</option>';
        if ($cities->count() > 0) {
            foreach ($cities as $city) {
                $response .= "<option value=" . $city->code . ">" . $city->name . "</option>";
            }
        }

        return response()->json(['cities' => $response]);
    }

}
