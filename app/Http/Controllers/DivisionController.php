<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function division()
    {
        $title = 'Division';
        return view('division', compact(['title']));
    }

    public function division_process(Request $request)
    {
        if ($request->action == 'add-division') {
            Division::create([
                'name' => $request->division,
            ]);
            return response()->json(['status' => true]);
        }elseif ($request->action == 'edit-division'){
            Division::where('id', $request->id)->update([
                'name' => $request->division,
            ]);
            return response()->json(['status' => true]);
        }else{
            Division::where('id', $request->id)->delete();
            return response()->json(['status' => true]);
        }
    }

    public function getDivisions()
    {
        $divisions = Division::get();
        return json_encode(array('data' => $divisions));
    }

    public function edit_division(Request $request)
    {
        $data = Division::where('id', $request->id)->first();
        return response()->json(['data'=>$data]);
    }

}
