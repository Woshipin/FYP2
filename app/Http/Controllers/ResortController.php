<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resort;
use App\Models\User;
use App\Events\HotelStatus;
use App\Models\ResortRating;
use App\Models\ResortImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResortController extends Controller
{

    public function addResort(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'map' => 'required',
            'location' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
        ]);

        $resort = new Resort();
        $resort->user_id = auth()->id();
        $resort->name = $request->name;
        $resort->price = $request->price;
        $resort->type = $request->type;
        $resort->phone = $request->phone;
        $resort->email = $request->email;
        $resort->country = $request->country;
        $resort->state = $request->state;
        $resort->latitude = $request->latitude;
        $resort->longitude = $request->longitude;
        $resort->map = $request->map;
        $resort->location = $request->location;
        $resort->description = $request->description;
        $resort->latitude = $request->latitude;
        $resort->longitude = $request->longitude;
        $resort->digital_lock_password = $request->digital_lock_password;
        $resort->emailbox_password = $request->emailbox_password;
        $resort->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                Log::info('Uploading image: ' . $image->getClientOriginalName());

                $imageName = time() . '_' . $image->getClientOriginalName(); // 防止文件名重复
                $image->move(public_path('images'), $imageName);

                Log::info('Saving image to database: ' . $imageName);

                $resortImage = new ResortImage();
                $resortImage->resort_id = $resort->id;
                $resortImage->image = $imageName;
                $resortImage->save();
            }
        }

        return back()->with('success', 'You have added a new Resort successfully');
    }

    public function showResort() {
        $user = auth()->user();
        $resorts = $user->resorts()->get(); // Not paginated
        $resortss = $user->resorts()->paginate(10); // Paginated, 10 results per page

        return view('backend-user.backend-resort.resort', ['resorts' => $resorts, 'resortss' => $resortss]);
    }

    public function showResortMap($resortId)
    {
        $resorts = Resort::find($resortId);

        return view('backend-user.backend-resort.viewresort',compact('resorts'));
    }

    public function showAllResortMap()
    {
        $resorts = Resort::all();

        return view('backend-user.backend-resort.resort', compact('resorts'));
    }

    // public function editResort($id){

    //     $resorts = Resort::find($id);

    //     return view('backend-user.backend-resort.resort',compact('resorts'));
    // }

    // public function updateResort(Request $request, $id){

    //     $resorts = Resort::find($id);

    //     // Check if a new image is uploaded
    //     if ($request->hasFile('image')) {

    //         $image = $request->file('image');
    //         $image->move('images', $image->getClientOriginalName());
    //         $imageName = $image->getClientOriginalName();
    //         $resorts->image = $imageName;

    //     } else {
    //         // Keep the original image value or set it to null if it's empty
    //         $resorts->image = $resorts->image ?: null;
    //     }

    //     $resorts->name = $request->name;
    //     $resorts->price = $request->price;
    //     $resorts->location = $request->location;
    //     $resorts->phone = $request->phone;
    //     $resorts->type = $request->type;
    //     $resorts->email = $request->email;
    //     $resorts->country = $request->country;
    //     $resorts->state = $request->state;
    //     $resorts->map = $request->map;
    //     $resorts->description = $request->description;
    //     $resorts->save();

    //     return back()->with('success','This Resort has been updated successfully.');
    // }

    public function editResort($id){

        $resorts = Resort::find($id);

        return view('backend-user.backend-resort.resort',compact('resorts'));
    }

    public function updateResort(Request $request, $id)
    {
        $resort = Resort::find($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'location' => 'required',
            'phone' => 'required',
            'type' => 'required',
            'email' => 'required',
            'country' => 'required',
            'state' => 'required',
            'map' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
        ]);

        $resort->name = $request->name;
        $resort->price = $request->price;
        $resort->location = $request->location;
        $resort->phone = $request->phone;
        $resort->type = $request->type;
        $resort->email = $request->email;
        $resort->country = $request->country;
        $resort->state = $request->state;
        $resort->map = $request->map;
        $resort->description = $request->description;
        $resort->latitude = $request->latitude;
        $resort->longitude = $request->longitude;
        $resort->digital_lock_password = $request->digital_lock_password;
        $resort->emailbox_password = $request->emailbox_password;
        $resort->save();

        // Handle image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                $resortImage = new ResortImage();
                $resortImage->resort_id = $resort->id;
                $resortImage->image = $imageName;
                $resortImage->save();
            }
        }

        return back()->with('success', 'This Resort has been updated successfully.');
    }

    public function deleteResortImage($id)
    {
        $image = ResortImage::find($id);
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

    public function deleteResort($id){

        Resort::where('id',$id)->delete();

        return back()->with('success','This Resort has been delete.');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = json_decode($request->input('ids')); // Convert JSON string back to array
        Resort::whereIn('id', $ids)->delete();

        return back()->with('success', 'The selected Resorts have been deleted successfully!');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Resort::whereIn('id', $ids)->delete();

        return response()->json(['success' => "Resort have been Deleted!"]);
    }

    public function changeresortStatus($id)
    {
        $getstatus = Resort::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        event(new HotelStatus());

        Resort::where('id', $id)->update(['status' => $status]);

        return back()->with(compact('status'));
    }

    public function ResortSearch(Request $request)
    {
        $user = auth()->user();
        $resorts = $user->resorts()->get(); // Not paginated
        $resortss = $user->resorts()->paginate(10); // Paginated, 10 results per page

        // Build your database query based on the input values
        $query = Resort::query();

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->country) {
            $query->where('country', 'LIKE', '%' . $request->country . '%');
        }

        if ($request->state) {
            $query->where('state', 'LIKE', '%' . $request->state . '%');
        }

        if ($request->location) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->price) {
            // Convert the request value to a numeric type (e.g., float) if necessary
            $priceValue = floatval($request->price);

            // Use comparison operators to search for prices
            $query->where('price', '=', $priceValue); // Search for prices less than or equal to the specified value
        }

        if($request->name && $request->price)
        {
            $resortss = Resort::where('name', 'LIKE', '%' . $request->name . '%')
                                ->where('price', '=', $priceValue)
                                ->get();
        }

        if($request->country && $request->state && $request->location)
        {
            $resortss = Resort::where('country', 'LIKE', '%' . $request->country . '%')
                                ->where('state', 'LIKE', '%' . $request->state . '%')
                                ->where('location', 'LIKE', '%' . $request->location . '%')
                                ->get();
        }

        if($request->name && $request->country && $request->state && $request->location && $request->price)
        {
            $resortss = Resort::where('name', 'LIKE', '%' . $request->name . '%')
                                ->where('country', 'LIKE', '%' . $request->country . '%')
                                ->where('state', 'LIKE', '%' . $request->state . '%')
                                ->where('location', 'LIKE', '%' . $request->location . '%')
                                ->where('price', '=', $priceValue)
                                ->get();
        }

        // dd($resortss);

        // Execute the query and retrieve the results
        $resortss = $query->paginate(10);

        // Execute the query
        // $results = $query->get();
        // dd($result);
        // {{ dd($results) }}

        return view('backend-user.backend-resort.resort', compact('resorts','resortss'));
    }

    // -------------------------------------------------Frontend----------------------------------------------------------- //

    //Frontend Function
    // public function AllResort(){

    //     $resort = Resort::all();

    //     return view('frontend-auth.frontend-resort.resort',compact('resort'));
    // }

    public function AllResort()
    {
        $resort = Resort::with('images')->get();
        return view('frontend-auth.frontend-resort.resort', compact('resort'));
    }

    public function ResortDetail($id)
    {
        $resort = Resort::find($id);

        if (!$resort) {
            return redirect()->back()->with('error', 'Resort not found.');
        }

        // 使用原生 SQL 查询计算平均评分
        $averageRating = DB::table('resort_ratings')
                            ->where('rateable_id', $resort->id)
                            ->where('rateable_name', $resort->name)
                            ->avg('rating');

        // 使用 Query Builder 查询计算评分数量
        $ratingCount = DB::table('resort_ratings')
                            ->where('rateable_id', $resort->id)
                            ->where('rateable_name', $resort->name)
                            ->count();

        // 如果需要单个评分，可以通过查询获取第一个评分
        $singleRating = DB::table('resort_ratings')
                            ->where('rateable_id', $resort->id)
                            ->where('rateable_name', $resort->name)
                            ->value('rating');

        // 调试信息
        // dd($averageRating, $ratingCount, $singleRating);

        return view('frontend-auth.frontend-resort.resort-detail', compact('resort', 'averageRating', 'ratingCount', 'singleRating'));
    }

    public function frontendresortsearch(Request $request)
    {
        $query = Resort::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('type', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('country', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('state', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('location', 'LIKE', '%' . $searchTerm . '%') // Changed 'address' to 'location'
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $resort = $query->get();

        if ($request->ajax()) {
            return response()->json($resort);
        }

        return view('frontend-auth.frontend-resort.resort',compact('resort'));
    }

    public function uploadAndSearch(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $matchedResorts = $this->findMatchingResorts($image);

        return response()->json($matchedResorts);
    }

    private function findMatchingResorts($image)
    {
        // 你的图片匹配逻辑
        // 示例：通过图片名匹配
        $imageName = $image->getClientOriginalName();

        // 假设 Resort 模型中有一个 image 字段存储图片名
        return Resort::where('image', $imageName)->get();
    }

    // public function gpsSearch(Request $request)
    // {
    //     $latitude = $request->query('latitude');
    //     $longitude = $request->query('longitude');
    //     $radius = 50000; // 50 km radius

    //     // Haversine formula to calculate distance
    //     $resorts = DB::select(
    //         'SELECT *,
    //         (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
    //         FROM resorts
    //         HAVING distance < ?
    //         ORDER BY distance',
    //         [$latitude, $longitude, $latitude, $radius / 1000]
    //     );

    //     return response()->json($resorts);
    // }

    public function gpsSearch(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = 50; // 50 km 范围

        try {

            $resorts = DB::select(
                'SELECT *,
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
                FROM resorts
                HAVING distance < ?
                ORDER BY distance',
                [$latitude, $longitude, $latitude, $radius]
            );

            return response()->json($resorts);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }



}
