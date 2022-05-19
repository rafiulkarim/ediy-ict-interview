<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\Union;
use App\Models\Upazila;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $divisions = Division::all();
        return view('dashboard', compact(['title', 'divisions']));
    }

    public function get_district(Request $request)
    {
        $population = Division::with(['district' => function ($district) {
            $district->with(['upazila' => function ($upazila) {
                $upazila->with('union')->get();
            }])->get();
        }])->where('id', $request->id)->first();

        $total = 0;
        foreach ($population->district as $district) {
            foreach ($district->upazila as $upazila) {
                foreach ($upazila->union as $union) {
                    $total = $total + (int)$union->population;
                }
            }
        }
        $datas = District::where('division_id', $request->id)->get();
        $html = '<option value="">Select One</option>';
        foreach ($datas as $data) {
            $html = $html . '<option value="' . $data->id . '">' . $data->name . '</option>';
        }

        $data = [$total, $html];
        return response()->json(['data' => $data]);
    }

    public function get_upazila(Request $request)
    {
        $population = District::with(['upazila' => function ($upazila) {
            $upazila->with(['union'])->get();
        }])->where('id', $request->id)->first();

        $total = 0;
        foreach ($population->upazila as $upazila) {
            foreach ($upazila->union as $union) {
                $total = $total + (int)$union->population;
            }
        }

        $datas = Upazila::where('district_id', $request->id)->get();
        $html = '<option value="">Select One</option>';
        foreach ($datas as $data) {
            $html = $html . '<option value="' . $data->id . '">' . $data->name . '</option>';
        }

        $data = [$total, $html];
        return response()->json(['data' => $data]);
    }

    public function get_union(Request $request)
    {
        $population = Upazila::with(['union'])->where('id', $request->id)->first();

        $total = 0;
        foreach ($population->union as $union) {
            $total = $total + (int)$union->population;
        }

        $datas = Union::where('upazila_id', $request->id)->get();
        $html = '<option value="">Select One</option>';
        foreach ($datas as $data) {
            $html = $html . '<option value="' . $data->id . '">' . $data->name . '</option>';
        }

        $data = [$total, $html];
        return response()->json(['data' => $data]);
    }

    public function get_population(Request $request)
    {
        $population = Union::where('id', $request->id)->first();
        return response()->json(['data'=>$population->population]);
    }

}
