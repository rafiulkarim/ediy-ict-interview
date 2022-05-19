<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\Union;
use App\Models\Upazila;
use Illuminate\Http\Request;

class UnionController extends Controller
{
    public function union()
    {
        $title = 'Union';
        $divisions = Division::all();
        return view('union', compact(['title', 'divisions']));
    }

    public function upazila_find(Request $request)
    {
        $upazilas = Upazila::where('district_id', $request->district_id)->orderBy('name', 'ASC')->get();
        $html = '<option value="">Select Upazila</option>';
        foreach ($upazilas as $upazila) {
            $html = $html . '<option value="' . $upazila->id . '">' . $upazila->name . '</option>';
        }

        return $html;
    }

    public function getUnion()
    {
        $data = Union::with(['upazila' => function ($upazila) {
            $upazila->with(['district' => function ($district) {
                $district->with(['division'])->get();
            }])->get();
        }])->get();
        return response()->json(['data' => $data]);
    }

    public function union_process(Request $request)
    {
        if ($request->action == 'add-union') {
            Union::create([
                'name' => $request->union,
                'population' => $request->population,
                'upazila_id' => $request->upazila,
            ]);
            return response()->json(['status' => true]);
        }elseif ($request->action == 'edit-union'){
            Union::where('id', $request->id)->update([
                'name' => $request->union,
                'population' => $request->population,
                'upazila_id' => $request->upazila,
            ]);
            return response()->json(['status' => true]);
        }else{
            Union::where('id', $request->id)->delete();
            return response()->json(['status' => true]);
        }
    }

    public function edit_union(Request $request)
    {
        $union = Union::with(['upazila' => function ($upazila) {
            $upazila->with(['district' => function ($district) {
                $district->with(['division'])->get();
            }])->get();
        }])->where('id', $request->id)->first();

        $upazila = Upazila::where('district_id', $union->upazila->district_id)->get();
        $districts = District::where('division_id', $union->upazila->district->division_id)->get();
        $divisions = Division::all();

        $data = [$union, $upazila, $districts, $divisions];
        return response()->json(['data'=>$data]);

    }
}
