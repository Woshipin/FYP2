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

        // 验证请求数据
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id', // 确保 restaurant_id 存在
            'title' => 'required|string',
            // 添加其他字段的验证规则
        ]);

        // 查找餐厅记录
        $restaurant = Restaurant::find($validatedData['restaurant_id']);

        // 如果餐厅不存在，返回错误
        if (!$restaurant) {
            return back()->with('error', 'Restaurant not found.')->withInput();
        }

        // 创建新桌子记录
        $table = $user->tables()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'title' => $validatedData['title'],
            // 添加其他字段的值
        ]);

        // 返回成功消息
        return back()->with('success', 'Table added successfully.');
    }

    public function editTable($id){

        $tables = Table::find($id);
        $restaurantd = Restaurant::find($id);

        return view('backend-user.backend-restaurant.edit-table',compact('restaurantd','tables'));
        return view('backend-user.backend-restaurant.restaurant',compact('restaurantd','tables'));
    }

    public function updateTable(Request $request, $id)
    {
        // 验证请求数据
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id', // 确保 restaurant_id 存在
            'title' => 'required|string',
        ]);

        // 查找桌子记录
        $tables = Table::find($id);

        // 如果桌子不存在，返回错误
        if (!$tables) {
            return back()->with('error', 'Table not found.')->withInput();
        }

        // 更新桌子信息
        $tables->restaurant_id = $validatedData['restaurant_id'];
        $tables->title = $validatedData['title'];
        $tables->save();

        // 返回成功消息
        return back()->with('success', 'Table updated successfully.');
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
