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
use App\Models\RestaurantCommunity;
use App\Models\RestaurantCommunityMultipleImage;
use App\Models\CommunityCategory;

use Intervention\Image\Facades\Image;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

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
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
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
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
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

    public function deleteRestaurantImage($id)
    {
        $image = RestaurantImage::find($id);
        if ($image) {
            // 删除图片文件
            $imagePath = public_path('images/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // 删除数据库中的记录
            $image->delete();

            return response()->json(['message' => 'Image deleted successfully.']);
        } else {
            return response()->json(['message' => 'Image not found.'], 404);
        }
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
    // public function allRestaurant()
    // {
    //     $restaurant = Restaurant::with('images')->where('register_status', 1)->get();
    //     $restaurantRatings = [];

    //     foreach ($restaurant as $r) {
    //         $ratings = $r->ratings;
    //         $averageRating = $ratings->avg('rating') ?? 0; // 如果没有评分，默认为 0
    //         $restaurantRatings[$r->id] = [
    //             'averageRating' => $averageRating,
    //             'count' => $ratings->count()
    //         ];
    //     }

    //     // 确保 $restaurant 是一个数组
    //     $restaurantArray = $restaurant->toArray();

    //     return view('frontend-auth.frontend-restaurant.restaurant', compact('restaurant', 'restaurantArray', 'restaurantRatings'));
    // }

    public function allRestaurant()
    {
        // Get all restaurants with preloaded images
        $restaurant = Restaurant::with('images')
            ->where('register_status', 1)
            ->get();

        $restaurantRatings = [];

        // Calculate average ratings for each restaurant using Query Builder
        foreach ($restaurant as $r) {
            // Get ratings using Query Builder
            $ratings = DB::table('restaurant_ratings')
                ->where('rateable_id', $r->id)
                ->where('rateable_name', $r->name);

            // Calculate average rating
            $averageRating = $ratings->avg('rating') ?? 0;

            // Get rating count
            $ratingCount = $ratings->count();

            $restaurantRatings[$r->id] = [
                'averageRating' => round($averageRating, 1), // Round to 1 decimal place
                'count' => $ratingCount
            ];
        }

        // Pass data to view with restaurantRatings as JSON for JavaScript
        return view('frontend-auth.frontend-restaurant.restaurant', [
            'restaurant' => $restaurant,
            'restaurantArray' => $restaurant->toArray(),
            'restaurantRatings' => $restaurantRatings
        ]);
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

        $communitycategorys = CommunityCategory::all();

        // 获取该 hotel 的所有 community
        $communities = DB::table('restaurant_communities')
        ->where('restaurant_id', $restaurants->id)
        ->get();

        return view('frontend-auth.frontend-restaurant.restaurant-detail',compact('restaurants','restaurantId','averageRating', 'ratingCount'
        , 'singleRating','communitycategorys','communities'));
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
        try {
            $image = $request->file('image');
            $matchedRestaurants = $this->findMatchingRestaurants($image);
            \Log::info('Matched restaurants:', $matchedRestaurants);
            return response()->json($matchedRestaurants);
        } catch (\Exception $e) {
            \Log::error('Error in uploadAndSearchRestaurants:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function findMatchingRestaurants($image)
    {
        $hasher = new ImageHash(new DifferenceHash());
        $uploadedImagePath = $image->getRealPath();
        if (!file_exists($uploadedImagePath)) {
            \Log::error('Uploaded image file does not exist: ' . $uploadedImagePath);
            throw new \Exception('Uploaded image file does not exist');
        }
        $uploadedImageHash = $hasher->hash($uploadedImagePath);
        $restaurantImages = RestaurantImage::all();
        $matchedRestaurantIds = [];
        $threshold = 5; // 调整阈值以提高匹配准确性

        foreach ($restaurantImages as $restaurantImage) {
            $dbImagePath = public_path('images/' . $restaurantImage->image);
            if (!file_exists($dbImagePath)) {
                \Log::warning('Database image file does not exist: ' . $dbImagePath);
                continue;
            }
            try {
                $dbImageHash = $hasher->hash($dbImagePath);
                $distance = $hasher->distance($uploadedImageHash, $dbImageHash);
                \Log::info("Image comparison:", [
                    'uploaded_image' => $uploadedImagePath,
                    'db_image' => $dbImagePath,
                    'distance' => $distance
                ]);
                if ($distance <= $threshold) {
                    $matchedRestaurantIds[] = $restaurantImage->restaurant_id;
                }
            } catch (\Exception $e) {
                \Log::error('Error processing image: ' . $dbImagePath, ['error' => $e->getMessage()]);
            }
        }
        $matchedRestaurantIds = array_unique($matchedRestaurantIds);
        $matchedRestaurants = Restaurant::with('images')->whereIn('id', $matchedRestaurantIds)->get();
        $matchedRestaurantsArray = $matchedRestaurants->map(function ($restaurant) {
            $restaurantArray = $restaurant->toArray();
            $restaurantArray['images'] = $restaurant->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => $image->image,
                    'url' => asset('images/' . $image->image)
                ];
            });
            return $restaurantArray;
        })->toArray();
        \Log::info('Matched restaurants:', $matchedRestaurantsArray);
        return $matchedRestaurantsArray;
    }

    public function RestaurantgpsSearch(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = 150; // 150 km range

        try {
            $restaurants = DB::table('restaurants')
                ->select('restaurants.*',
                    DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance'))
                // ->where('register_status', 1) // 只选择 register_status 为 1 的餐馆
                ->having('distance', '<', $radius)
                ->orderBy('distance')
                ->setBindings([$latitude, $longitude, $latitude])
                ->get();

            // Fetch the first image for each restaurant
            foreach ($restaurants as $restaurant) {
                $image = DB::table('restaurant_images')
                    ->where('restaurant_id', $restaurant->id)
                    ->value('image');
                $restaurant->image = $image;
            }

            return response()->json($restaurants);

        } catch (\Exception $e) {
            // Log the error to Laravel's log files
            \Log::error('Error in GPS Search:', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(), // Using getTraceAsString to limit the output
            ]);

            // Return a JSON response indicating failure
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'An error occurred while processing your request. Please try again.'
            ], 500);
        }
    }

    // --------------------------------------------------------- Restaurant Community Area  ---------------------------------------------- //
    // Show the community form
    public function showRestaurantCommunityForm($id)
    {
        // 确保用户已登录
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'You must be logged in to view the community form.');
        }

        // 获取指定 restaurant_id 的所有社区，并预加载 multipleImages
        $communities = RestaurantCommunity::with('multipleImages')->where('restaurant_id', $id)->get();

        $communitycategorys = CommunityCategory::all();

        // 返回视图并传递数据
        return view('backend-user.backend-restaurant.restaurant-community', compact('communities', 'id','communitycategorys'));
    }

    // Save a new restaurant community
    public function saveRestaurantCommunity(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'nullable|array',
            'cultural' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        // 创建社区记录
        $community = new RestaurantCommunity();
        $community->restaurant_id = $id;
        $community->name = $request->name;
        $community->category = $request->category;
        $community->cultural = $request->cultural;
        $community->address = $request->address;
        $community->latitude = $request->latitude;
        $community->longitude = $request->longitude;
        $community->description = $request->description;
        $community->save();

        // 处理图像上传
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                Log::info('Uploading image: ' . $image->getClientOriginalName());

                // 防止文件名重复
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                Log::info('Saving image to database: ' . $imageName);

                // 保存到 RestaurantCommunityMultipleImage 表
                $communityImage = new RestaurantCommunityMultipleImage();
                $communityImage->community_id = $community->id;
                $communityImage->image_path = 'images/' . $imageName; // 保存完整路径
                $communityImage->save();
            }
        }

        return redirect()->back()->with('success', 'Community added successfully.');
    }

    // Update a restaurant community
    public function updateRestaurantCommunity(Request $request, $id)
    {
        $community = RestaurantCommunity::findOrFail($id);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'nullable|array',
            'cultural' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        // Update the community data
        $community->name = $request->name;
        $community->category = $request->category;
        $community->cultural = $request->cultural;
        $community->address = $request->address;
        $community->latitude = $request->latitude;
        $community->longitude = $request->longitude;
        $community->description = $request->description;

        // Handle image uploads using the same approach as `saveCommunity`
        if ($request->hasFile('image')) {
            // 删除旧图片记录及文件
            foreach ($community->multipleImages as $existingImage) {
                $existingImagePath = public_path($existingImage->image_path);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath); // 删除实际文件
                }
                $existingImage->delete(); // 删除数据库记录
            }

            // 上传新图片并保存数据库记录
            foreach ($request->file('image') as $image) {
                // 防止文件名冲突
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                // 保存到数据库
                $community->multipleImages()->create([
                    'image_path' => 'images/' . $imageName, // 保存完整路径
                ]);
            }
        }

        // Save the updated community
        $community->save();

        return redirect()->back()->with('success', 'Community updated successfully.');
    }

    // Delete a restaurant community
    public function deleteRestaurantCommunity($id)
    {
        // Find the community by id
        $community = RestaurantCommunity::findOrFail($id);

        // Delete the community
        $community->delete();

        // Redirect with success message
        return redirect()->back()->with('success', 'Community deleted successfully.');
    }

    public function RestaurantCommunityImageDestroy($id)
    {
        $image = RestaurantCommunityMultipleImage::findOrFail($id);

        // 删除图片文件
        $imagePath = public_path('images/' . $image->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // 从数据库中删除记录
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully.']);
    }

    public function showRestaurantCommunityDetail($id) {

        $community = RestaurantCommunity::find($id);

        return view('frontend-auth.frontend-restaurant.restaurant-community-detail', compact('community'));
    }
}
