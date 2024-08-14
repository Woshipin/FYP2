<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    // public function showTables()
    // {
    //     $user = auth()->user();
    //     $restaurantd = $user->restaurants()->get();
    //     $tables = $user->tables()->get();

    //     return view('backend-user.backend-restaurant.restaurant', compact('tables', 'restaurantd'));
    // }


    public function addTable(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'restaurant_id' => 'required',
            'title' => 'required|string',
            // Add validation rules for other table columns
        ]);

        $restaurant = Restaurant::findOrFail($validatedData['restaurant_id']);

        $table = $user->tables()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'title' => $validatedData['title'],
            // Add other table column values
        ]);

        // Perform any additional actions if needed

        return redirect()->back()->with('table', 'Table added successfully.');
    }

    public function editTable($id){

        $tables = Table::find($id);
        $restaurantd = Restaurant::find($id);

        return view('backend-user.backend-restaurant.restaurant',compact('restaurantd','tables'));
    }

    public function updateTable(Request $request, $id){

        $tables = Table::find($id);

        $tables->restaurant_id = $request->restaurant_id;
        $tables->title = $request->title;
        $tables->save();

        return back()->with('table','This Table has been updated successfully.');
    }

    public function deleteTable($id){

        Table::where('id',$id)->delete();

        return back()->with('table','This Table has been delete.');
    }

    public function deleteMultipletable(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            Table::whereIn('id', $ids)->delete();

            return back()->with('table', 'Selected Tables have been deleted successfully!');

        } else {

            return back()->with('tables', 'Invalid input. No Tables were deleted.');
        }
    }

    public function deleteAlltable(Request $request)
    {
        $ids = $request->ids;
        Table::whereIn('id', $ids)->delete();

        return back()->with('table', 'Selected Tables have been deleted successfully!');
    }


    //testing
    public function showTables()
    {
        $user = auth()->user();
        $restaurantd = $user->restaurants()->get();
        $tables = $user->tables()->get();
        $tabless = $user->tables()->paginate(10);

        return view('backend-user.backend-restaurant.table', compact('tables', 'restaurantd','tabless'));
    }

    public function changetableStatus($id)
    {
        $getstatus = Table::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        Table::where('id', $id)->update(['status' => $status]);

        return back()->with(compact('status'));
    }

    // public function editTable1($id){

    //     $tables = Table::find($id);
    //     $restaurantd = Restaurant::find($id);

    //     return view('user.table',compact('restaurantd','tables'));
    // }

}
