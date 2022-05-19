<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function district()
    {
        $title = 'District';
        $divisions = Division::all();
        return view('district', compact('title', 'divisions'));
    }

    public function getDistrict()
    {
        $district = District::with('division')->get();
        return response()->json(['data' => $district]);
    }

    public function district_process(Request $request)
    {
        if ($request->action == 'add-district') {
            District::create([
                'name' => $request->district,
                'division_id' => $request->division
            ]);
            return response()->json(['status' => true]);
        }elseif ($request->action == 'edit-district'){
            District::where('id', $request->id)->update([
                'name' => $request->district,
                'division_id' => $request->division
            ]);
            return response()->json(['status' => true]);
        }else{
            District::where('id', $request->id)->delete();
            return response()->json(['status' => true]);
        }
    }

    public function edit_district(Request $request)
    {
        $district = District::with('division')->where('id', $request->id)->first();
        $division = Division::all();
        $data = [$district, $division];
        return response()->json(['data'=>$data]);
    }
}
