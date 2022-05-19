<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Http\Request;

class UpazilaController extends Controller
{
    public function upazila()
    {
        $title = 'Upazila';
        $divisions = Division::orderBy('name', 'ASC')->get();
        $districts = District::orderBy('name', 'ASC')->get();
        return view('upazila', compact(['title', 'divisions', 'districts']));
    }

    public function district_find(Request $request)
    {
        $districts = District::where('division_id', $request->division_id)->orderBy('name', 'ASC')->get();
        $html = '<option value="">Select District</option>';
        foreach ($districts as $district) {
            $html = $html . '<option value="' . $district->id . '">' . $district->name . '</option>';
        }

        return $html;
    }

    public function getUpazila()
    {
        $upazila = Upazila::with(['district' => function ($district) {
            $district->with(['division'])->get();
        }])->get();

        return response()->json(['data' => $upazila]);
    }

    public function upazila_process(Request $request)
    {
        if ($request->action == 'add-upazila') {
            Upazila::create([
                'name' => $request->upazila,
                'district_id' => $request->district
            ]);
            return response()->json(['status' => true]);
        } elseif ($request->action == 'edit-upazila') {
            Upazila::where('id', $request->id)->update([
                'name' => $request->upazila,
                'district_id' => $request->district
            ]);
            return response()->json(['status' => true]);
        }else{
            Upazila::where('id', $request->id)->delete();
            return response()->json(['status' => true]);
        }
    }

    public function edit_upazila(Request $request)
    {
        $upazila = Upazila::with(['district' => function ($district) {
            $district->with(['division'])->get();
        }])->where('id', $request->id)->first();
        $districts = District::where('division_id', $upazila->district->division_id)->get();
        $divisions = Division::all();
        $data = [$upazila, $districts, $divisions];
        return response()->json(['data' => $data]);
    }
}
