<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Session;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function viewstaff(){

        return view('staff.staffmodel');
    }

    public function addStaff(Request $request){

        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'salary'=>'required',
            'address'=>'required'
        ]);

        $staff = new Staff();
        $staff->name = $request->name;
        $staff->phone = $request->phone;
        $staff->salary = $request->salary;
        $staff->address = $request->address;
        $staff->save();

        return back()->with('success', 'You have add new staff successfully');
    }

    public function showstaff(){

        $staffs = Staff::paginate(10);

        return view('staff.staffmodel',compact('staffs'));
    }

    public function editstaff($id){

        $staffs = Staff::find($id);
        return view('staff.staffmodal',compact('staffs'));
    }

    public function updatestaff(Request $request, $id){

        $staffs = Staff::find($id);

        $staffs->name=$request->name;
        $staffs->phone=$request->phone;
        $staffs->salary=$request->salary;
        $staffs->address=$request->address;
        $staffs->save();

        return back()->with('success','This Staff Already Update.');
    }

    public function deletestaff($id){

        Staff::where('id',$id)->delete();
        return back()->with('success','This Staff Already Delete.');
    }
}
