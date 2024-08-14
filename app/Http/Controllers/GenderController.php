<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gender;
use Illuminate\Support\Facades\Validator;

class GenderController extends Controller
{
    public function gender(){
        
        $genders = Gender::paginate(10); // You can adjust the number based on your needs

        return view('admin.gender', compact('genders'));
    }

    public function addGender(Request $request)
    {
        $request->validate([
            'gender' => 'required' // Update the field name to 'gender'
        ]);

        $genders = new Gender();
        $genders->title = $request->gender; // Update the field name to 'gender'
        $genders->save();

        return back()->with('success', 'The New Gender has been Created.');
    }

    public function editGender($id){

        $genders = Gender::find($id);

        return view('admin.gender',compact('genders'));
    }

    public function updateGender(Request $request, $id){

        $request->validate([
            'gender' => 'required' // Update the field name to 'gender'
        ]);

        $genders = Gender::find($id);

        $genders->title = $request->gender;
        $genders->save();

        return back()->with('success', 'The Gender has been Updated.');
    }

    public function deleteGender(){

        Gender::where('id',$id)->delete();

        return back()->with('success','This Gender has been delete.');
    }
}
