<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\workers;

class CompanyController extends Controller
{
    public function index()
    {

        $companyUsers = workers::all();
        return response()->json($companyUsers);
    }

// public function store(Request $request){
//     $companyUsers = new workers([
//         'name' => $request->input('name'),
//         'address' => $request->input('address'),
//         'mobile' => $request->input('mobile'),
//     ]);
//     $companyUsers->save();
//     return response()->json('Company User created!');
// }


public function store(Request $request){
    $validated = $request -> validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'mobile' => 'required|numeric|digits_between:10,15',

    ]);

    $companyUsers = new workers([
        'name' => $request->input('name'),
        'address' => $request->input('address'),
        'mobile' => $request->input('mobile'),
    ]);
    $companyUsers->save();
    // return response()->json('Company User created!');
    return response()->json(['message' => "Company User created!", 'companyUsers'=>$companyUsers],200);

}



public function show($id){
    $contact = workers::find($id);
    return response()->json($contact);
}

// public function update(Request $request, $id){
//     $companyUsers = workers::find($id);
//     return response()->json("Updated");
// }
public function update(Request $request, $id){
    $companyUsers = workers::find($id);

    if (!$companyUsers) {
        return response()->json('Company User not found!', 404);
    }

    $companyUsers->name = $request->input('name');
    $companyUsers->address = $request->input('address');
    $companyUsers->mobile = $request->input('mobile');

    $companyUsers->save();

    return response()->json('Company User updated!');
}
public function destroy($id){
    $companyUsers = workers::find($id);
    $companyUsers->delete();
    return response()->json('Deleted');
}




}
