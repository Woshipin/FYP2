<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use App\Events\HotelStatus;
use App\Models\RestaurantImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{

    public function addRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'address' => 'required',
            'description' => 'required',
            'map' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
        ]);

        $restaurant = new Restaurant();
        $restaurant->user_id = auth()->id();
        $restaurant->name = $request->name;
        $restaurant->phone = $request->phone;
        $restaurant->type = $request->type;
        $restaurant->email = $request->email;
        $restaurant->country = $request->country;
        $restaurant->state = $request->state;
        $restaurant->date = $request->date;
        $restaurant->time = $request->time;
        $restaurant->address = $request->address;
        $restaurant->description = $request->description;
        $restaurant->map = $request->map;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                Log::info('Uploading image: ' . $image->getClientOriginalName());

                $imageName = time() . '_' . $image->getClientOriginalName(); // 防止文件名重复
                $image->move(public_path('images'), $imageName);

                Log::info('Saving image to database: ' . $imageName);

                $restaurantImage = new RestaurantImage();
                $restaurantImage->restaurant_id = $restaurant->id;
                $restaurantImage->image = $imageName;
                $restaurantImage->save();
            }
        }

        return back()->with('success', 'You have added a new Restaurant successfully');
    }

    public function showRestaurant()
    {
        $user = auth()->user();
        $restaurants = $user->restaurants()->get();
        $restaurantd = $user->restaurants()->get();
        $tables = $user->tables()->get();
        $restaurantss = $user->restaurants()->paginate(10);
        $tabless = $user->tables()->paginate(10);

        return view('backend-user.backend-restaurant.restaurant', compact('restaurants','restaurantd','tables','restaurantss','tabless'));
    }

    public function viewRestaurant($id)
    {
        $restaurants = Restaurant::find($id);

        return view('backend-user.backend-restaurant.viewrestaurant',compact('restaurants'));
    }

    public function editRestaurant($id){

        $restaurant = Restaurant::find($id);

        return view('backend-user.backend-restaurant.restaurant', compact('restaurant'));
    }

    public function updateRestaurant(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);

        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'address' => 'required',
            'description' => 'required',
            'map' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
        ]);

        $restaurant->name = $request->name;
        $restaurant->phone = $request->phone;
        $restaurant->type = $request->type;
        $restaurant->email = $request->email;
        $restaurant->country = $request->country;
        $restaurant->state = $request->state;
        $restaurant->date = $request->date;
        $restaurant->time = $request->time;
        $restaurant->address = $request->address;
        $restaurant->description = $request->description;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->map = $request->map;
        $restaurant->save();

        // Handle image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                Log::info('Uploading image: ' . $image->getClientOriginalName());

                $imageName = time() . '_' . $image->getClientOriginalName(); // 防止文件名重复
                $image->move(public_path('images'), $imageName);

                Log::info('Saving image to database: ' . $imageName);

                $restaurantImage = new RestaurantImage();
                $restaurantImage->restaurant_id = $restaurant->id;
                $restaurantImage->image = $imageName;
                $restaurantImage->save();
            }
        }

        return back()->with('success', 'This Restaurant has been updated successfully.');
    }

    public function deleteRestaurant($id){

        Restaurant::where('id',$id)->delete();

        return back()->with('success','This Restaurant has been delete.');
    }

    public function deleteMultiplerestaurant(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            Restaurant::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected restaurants have been deleted successfully!');

        } else {

            return back()->with('error', 'Invalid input. No restaurants were deleted.');
        }
    }

    public function deleteAllrestaurant(Request $request)
    {
        $ids = $request->ids;
        Restaurant::whereIn('id', $ids)->delete();

        return back()->with('success', 'Selected restaurants have been deleted successfully!');
    }

    public function changerestaurantStatus($id)
    {
        $getstatus = Restaurant::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        event(new HotelStatus());

        Restaurant::where('id', $id)->update(['status' => $status]);

        return back()->with(compact('status'));
    }

    public function deleteAllRestaurantTable(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            Table::whereIn('id', $ids)->delete();

            return back()->with('table', 'Selected restaurants Table have been deleted successfully!');

        } else {

            return back()->with('tables', 'Invalid input. No restaurants Table were deleted.');
        }
    }

    public function RestaurantSearch(Request $request)
    {
        $user = auth()->user();
        $restaurants = $user->restaurants()->get();
        $restaurantd = $user->restaurants()->get();
        $restaurantss = $user->restaurants()->paginate(10);

        $tables = $user->tables()->get();
        $tabless = $user->tables()->paginate(10);

        // Build your database query based on the input values
        $query = Restaurant::query();

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->country) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        if ($request->state) {
            $query->where('state', 'LIKE', '%' . $request->state . '%');
        }

        if ($request->address) {
            $query->where('address', 'LIKE', '%' . $request->address . '%');
        }

        // Add date and time search conditions
        if ($request->date) {
            $query->whereDate('date_column', '=', $request->date);
        }

        if ($request->time) {
            $query->whereTime('time_column', '=', $request->time);
        }

        if($request->country && $request->state && $request->address)
        {
            $restaurantss = Restaurant::where('country', 'LIKE', '%' . $request->country . '%')
                            ->where('state', 'LIKE', '%' . $request->state . '%')
                            ->where('address', 'LIKE', '%' . $request->address . '%')
                            ->get();
        }

        if($request->date && $request->time)
        {
            $restaurantss = Restaurant::where('date_column', 'LIKE', '%' . $request->date . '%')
                            ->where('time_column', 'LIKE', '%' . $request->time . '%')
                            ->get();
        }

        // Execute the query and retrieve the results
        $restaurantss = $query->paginate(10);

        // Execute the query
        // $results = $query->get();
        // dd($result);
        // {{ dd($results) }}

        return view('backend-user.backend-restaurant.restaurant', compact('restaurants','restaurantd','tables','restaurantss','tabless'));
    }

    // -------------------------------------------------Frontend----------------------------------------------------------- //

    //Frontend Function
    public function allRestaurant(){

        $restaurant = Restaurant::with('images')->get();

        return view('frontend-auth.frontend-restaurant.restaurant',compact('restaurant'));
    }

    public function RestaurantDetail($id){

        $restaurants = Restaurant::find($id);
        $restaurantId = Restaurant::find($id);

        // 使用原生 SQL 查询计算平均评分
        $averageRating = DB::table('restaurant_ratings')
                            ->where('rateable_id', $restaurants->id)
                            ->where('rateable_name', $restaurants->name)
                            ->avg('rating');

        // 使用 Query Builder 查询计算评分数量
        $ratingCount = DB::table('restaurant_ratings')
                            ->where('rateable_id', $restaurants->id)
                            ->where('rateable_name', $restaurants->name)
                            ->count();

        // 如果需要单个评分，可以通过查询获取第一个评分
        $singleRating = DB::table('restaurant_ratings')
                            ->where('rateable_id', $restaurants->id)
                            ->where('rateable_name', $restaurants->name)
                            ->value('rating');

        return view('frontend-auth.frontend-restaurant.restaurant-detail',compact('restaurants','restaurantId','averageRating', 'ratingCount', 'singleRating'));
    }

    public function frontendrestaurantsearch(Request $request)
    {
        $query = Restaurant::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('type', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('country', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('state', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('address', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $restaurant = $query->get();

        if ($request->ajax()) {
            return response()->json($restaurant);
        }

        return view('frontend-auth.frontend-restaurant.restaurant',compact('restaurant'));
    }

    public function uploadAndSearchRestaurants(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $matchedRestaurants = $this->findMatchingRestaurants($image);

        return response()->json($matchedRestaurants);
    }

    private function findMatchingRestaurants($image)
    {
        // 你的图片匹配逻辑
        // 示例：通过图片名匹配
        $imageName = $image->getClientOriginalName();

        // 假设 Resort 模型中有一个 image 字段存储图片名
        return Restaurant::where('image', $imageName)->get();
    }

}
