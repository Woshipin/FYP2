<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Room;
use Pusher\Pusher;
use App\Events\HotelStatus;
use App\Models\HotelImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Intervention\Image\Facades\Image;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

class HotelController extends Controller
{

    public function index(){
        return view('user.hotel.hotel');
    }

    public function addHotel(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'country' => 'required',
            'state' => 'required',
            'map' => 'required',
            'address' => 'required',
            'description' => 'required',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate each image
        ]);

        // Create a new Hotel instance
        $hotel = new Hotel();
        $hotel->user_id = auth()->id();
        $hotel->name = $request->name;
        $hotel->type = $request->type;
        $hotel->phone = $request->phone;
        $hotel->email = $request->email;
        $hotel->country = $request->country;
        $hotel->state = $request->state;
        $hotel->map = $request->map;
        $hotel->address = $request->address;
        $hotel->description = $request->description;
        $hotel->latitude = $request->latitude;
        $hotel->longitude = $request->longitude;
        $hotel->digital_lock_password = $request->digital_lock_password;
        $hotel->emailbox_password = $request->emailbox_password;
        $hotel->save();

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                Log::info('Uploading image: ' . $image->getClientOriginalName());

                $imageName = time() . '_' . $image->getClientOriginalName(); // Prevent filename conflicts
                $image->move(public_path('images'), $imageName);

                Log::info('Saving image to database: ' . $imageName);

                $hotelImage = new HotelImage(); // Ensure you have a HotelImage model
                $hotelImage->hotel_id = $hotel->id;
                $hotelImage->image = $imageName;
                $hotelImage->save();
            }
        }

        return back()->with('success', 'You have added a new Hotel successfully');
    }

    public function showHotel(){

        $user = auth()->user();
        $hotels = $user->hotels()->get();
        $hotelss = $user->hotels()->paginate(10);

        // $hotels = $user->hotels()->get();
        $rooms = $user->rooms()->get();
        $roomss = $user->rooms()->paginate(10);

        // Search Hotel Function
        // Build your database query based on the input values
        // $query = Hotel::query();

        // if ($request->name) {
        //     $query->where('name', 'LIKE', '%' . $request->name . '%');
        // }

        // if ($request->country) {
        //     $query->where('country', 'LIKE', '%' . $request->country . '%');
        // }

        // if ($request->state) {
        //     $query->where('state', 'LIKE', '%' . $request->state . '%');
        // }

        // if ($request->address) {
        //     $query->where('address', 'LIKE', '%' . $request->address . '%');
        // }

        // if ($request->price) {
        //     $query->where('price', 'LIKE', '%' . $request->price . '%');
        // }

        // // Execute the query and retrieve the results
        // $results = $query->get();

        return view('backend-user.backend-hotel.hotel',compact('hotels','rooms','hotelss','roomss'));
    }

    public function viewHotel($id)
    {
        $hotel = Hotel::find($id);

        return view('backend-user.backend-hotel.viewhotel',compact('hotel'));
    }

    public function editHotel($id){

        $hotels = Hotel::find($id);

        return view('backend-user.backend-hotel.hotel', compact('hotels'));
    }

    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::find($id);

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'country' => 'required',
            'state' => 'required',
            'map' => 'required',
            'address' => 'required',
            'description' => 'required',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
        ]);

        $hotel->name = $request->name;
        $hotel->type = $request->type;
        $hotel->phone = $request->phone;
        $hotel->email = $request->email;
        $hotel->country = $request->country;
        $hotel->state = $request->state;
        $hotel->map = $request->map;
        $hotel->address = $request->address;
        $hotel->description = $request->description;
        $hotel->latitude = $request->latitude;
        $hotel->longitude = $request->longitude;
        $hotel->digital_lock_password = $request->digital_lock_password;
        $hotel->emailbox_password = $request->emailbox_password;
        $hotel->save();

        // 处理图像上传
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                $hotelImage = new HotelImage();
                $hotelImage->hotel_id = $hotel->id;
                $hotelImage->image = $imageName;
                $hotelImage->save();
            }
        }

        return back()->with('success', 'This Hotel has been updated successfully.');
    }

    public function deleteHotelImage($id)
    {
        $image = HotelImage::find($id);
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

    public function deleteHotel($id){

        Hotel::where('id',$id)->delete();

        return back()->with('success','This Hotel has been delete.');
    }

    public function mutlipledeletehotel(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            Hotel::whereIn('id', $ids)->delete();

            return back()->with('success', 'Selected Hotels have been deleted successfully!');

        } else {

            return back()->with('error', 'Invalid input. No Hotels were deleted.');
        }
    }

    public function mutlipledeleterooms(Request $request)
    {
        $ids = json_decode($request->input('idss'));

        if (is_array($ids) && count($ids) > 0) {

            Room::whereIn('id', $ids)->delete();

            return back()->with('room', 'Selected Rooms have been deleted successfully!');

        } else {

            return back()->with('rooms', 'Invalid input. No Rooms were deleted.');
        }
    }

    public function showHotelMap($hotelId)
    {
        $hotel = Hotel::find($hotelId);

        return view('backend-user.backend-hotel.viewhotel', compact('hotel'));
    }

    public function showAllHotelMap()
    {
        $user = auth()->user();

        $hotels = $user->hotels()->get();

        $hotels = $hotels->map(function ($hotel) {
            $hotel->latitude = (float) $hotel->latitude;
            $hotel->longitude = (float) $hotel->longitude;
            return $hotel;
        });

        return view('backend-user.backend-hotel.hotel', compact('hotels'));
    }

    public function changehotelStatus($id)
    {
        $getstatus = Hotel::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        event(new HotelStatus());

        Hotel::where('id', $id)->update(['status' => $status]);

        return back()->with(compact('status'));
    }

    public function HotelSearch(Request $request)
    {

        $user = auth()->user();
        $hotels = $user->hotels()->get();
        $hotelss = $user->hotels()->paginate(10);

        // $hotels = $user->hotels()->get();
        $rooms = $user->rooms()->get();
        $roomss = $user->rooms()->paginate(10);

        // Build your database query based on the input values
        $query = Hotel::query();

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

        if ($request->type) {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }

        if($request->name && $request->type)
        {
            $hotelss = Hotel::where('name', 'LIKE', '%' . $request->name . '%')
                                ->where('type', 'LIKE', '%' . $request->type . '%')
                                ->get();
        }

        if($request->country && $request->state && $request->address)
        {
            $hotelss = Hotel::where('country', 'LIKE', '%' . $request->country . '%')
                                ->where('state', 'LIKE', '%' . $request->state . '%')
                                ->where('address', 'LIKE', '%' . $request->address . '%')
                                ->get();
        }

        if($request->name && $request->country && $request->state && $request->address && $request->type)
        {
            $hotelss = Hotel::where('name', 'LIKE', '%' . $request->name . '%')
                                ->where('country', 'LIKE', '%' . $request->country . '%')
                                ->where('state', 'LIKE', '%' . $request->state . '%')
                                ->where('address', 'LIKE', '%' . $request->address . '%')
                                ->where('type', 'LIKE', '%' . $request->type . '%')
                                ->get();
        }

        // Execute the query and retrieve the results
        $hotelss = $query->paginate(10);

        return view('backend-user.backend-hotel.hotel', compact('hotels', 'rooms', 'hotelss', 'roomss'));
    }

    // -------------------------------------------------Frontend----------------------------------------------------------- //

    //Frontend Function
    // public function AllHotel(){

    //     $hotels = Hotel::with('images')->where('register_status', 1)->get();

    //     return view('frontend-auth.frontend-hotel.hotel',compact('hotels'));
    // }

    // public function AllHotel(Request $request){
    //     $latitude = $request->query('latitude');
    //     $longitude = $request->query('longitude');
    //     $radius = 150; // 150 km range

    //     if ($latitude && $longitude) {
    //         $hotels = Hotel::select('hotels.*')
    //             ->selectRaw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance', [$latitude, $longitude, $latitude])
    //             ->where('register_status', 1)
    //             ->having('distance', '<', $radius)
    //             ->orderBy('distance')
    //             ->with('images')
    //             ->get();
    //     } else {
    //         $hotels = Hotel::with('images')->where('register_status', 1)->get();
    //     }

    //     return view('frontend-auth.frontend-hotel.hotel', compact('hotels'));
    // }

    public function AllHotel(Request $request){
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = 150; // 150 km range
        if ($latitude && $longitude) {
            $hotels = Hotel::select('hotels.*')
                ->selectRaw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance', [$latitude, $longitude, $latitude])
                ->where('register_status', 1)
                ->having('distance', '<', $radius)
                ->orderBy('distance')
                ->with('images')
                ->get();
        } else {
            $hotels = Hotel::with('images')->where('register_status', 1)->get();
        }
        return view('frontend-auth.frontend-hotel.hotel', compact('hotels'));
    }

    public function HotelDetail($id)
    {
        // Retrieve the resort with the given ID from the database
        $hotels = Hotel::find($id);
        $hotelId = Hotel::find($id);

        if (!$hotels) {
            // Resort not found, handle the error accordingly (e.g., redirect or show an error message)
            return redirect()->back()->with('error', 'Resort not found.');
        }

        // 使用原生 SQL 查询计算平均评分
        $averageRating = DB::table('hotel_ratings')
                            ->where('rateable_id', $hotels->id)
                            ->where('rateable_name', $hotels->name)
                            ->avg('rating');

        // 使用 Query Builder 查询计算评分数量
        $ratingCount = DB::table('hotel_ratings')
                            ->where('rateable_id', $hotels->id)
                            ->where('rateable_name', $hotels->name)
                            ->count();

        // 如果需要单个评分，可以通过查询获取第一个评分
        $singleRating = DB::table('hotel_ratings')
                            ->where('rateable_id', $hotels->id)
                            ->where('rateable_name', $hotels->name)
                            ->value('rating');

        // Pass the resort data to the view
        return view('frontend-auth.frontend-hotel.hotel-detail', compact('hotels','hotelId','averageRating', 'ratingCount', 'singleRating'));
    }

    public function frontendhotelsearch(Request $request)
    {
        $query = Hotel::query();

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

        $hotels = $query->get();

        if ($request->ajax()) {
            return response()->json($hotels);
        }

        return view('frontend-auth.frontend-hotel.search_results', compact('hotels'));
    }

    public function uploadAndSearchHotels(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $image = $request->file('image');
            $matchedHotels = $this->findMatchingHotels($image);
            \Log::info('Matched hotels:', $matchedHotels);
            return response()->json($matchedHotels);
        } catch (\Exception $e) {
            \Log::error('Error in uploadAndSearchHotels:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function findMatchingHotels($image)
    {
        $hasher = new ImageHash(new DifferenceHash());
        $uploadedImagePath = $image->getRealPath();
        if (!file_exists($uploadedImagePath)) {
            \Log::error('Uploaded image file does not exist: ' . $uploadedImagePath);
            throw new \Exception('Uploaded image file does not exist');
        }
        $uploadedImageHash = $hasher->hash($uploadedImagePath);
        $hotelImages = HotelImage::all();
        $matchedHotelIds = [];
        $threshold = 5; // 调整阈值以提高匹配准确性

        foreach ($hotelImages as $hotelImage) {
            $dbImagePath = public_path('images/' . $hotelImage->image);
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
                    $matchedHotelIds[] = $hotelImage->hotel_id;
                }
            } catch (\Exception $e) {
                \Log::error('Error processing image: ' . $dbImagePath, ['error' => $e->getMessage()]);
            }
        }
        $matchedHotelIds = array_unique($matchedHotelIds);
        $matchedHotels = Hotel::with('images')->whereIn('id', $matchedHotelIds)->get();
        $matchedHotelsArray = $matchedHotels->map(function ($hotel) {
            $hotelArray = $hotel->toArray();
            $hotelArray['images'] = $hotel->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => $image->image,
                    'url' => asset('images/' . $image->image)
                ];
            });
            return $hotelArray;
        })->toArray();
        \Log::info('Matched hotels:', $matchedHotelsArray);
        return $matchedHotelsArray;
    }

    // public function HotelgpsSearch(Request $request)
    // {
    //     $latitude = $request->query('latitude');
    //     $longitude = $request->query('longitude');
    //     $radius = 150; // 150 km range

    //     try {
    //         $hotels = DB::table('hotels')
    //             ->select('hotels.*',
    //                 DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance'))
    //             ->having('distance', '<', $radius)
    //             ->orderBy('distance')
    //             ->setBindings([$latitude, $longitude, $latitude])
    //             ->get();

    //         // Fetch the first image for each hotel
    //         foreach ($hotels as $hotel) {
    //             $image = DB::table('hotel_images')
    //                 ->where('hotel_id', $hotel->id)
    //                 ->value('image');
    //             $hotel->image = $image;
    //         }

    //         return response()->json($hotels);

    //     } catch (\Exception $e) {
    //         // Log the error to Laravel's log files
    //         \Log::error('Error in GPS Search:', [
    //             'message' => $e->getMessage(),
    //             'exception' => get_class($e),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString(), // Using getTraceAsString to limit the output
    //         ]);

    //         // Return a JSON response indicating failure
    //         return response()->json([
    //             'error' => 'Internal Server Error',
    //             'message' => 'An error occurred while processing your request. Please try again.'
    //         ], 500);
    //     }
    // }

    public function HotelgpsSearch(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = 150; // 150 km range

        try {
            $hotels = DB::table('hotels')
                ->select('hotels.*',
                    DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance'))
                ->where('register_status', 1) // 只选择 register_status 为 1 的酒店
                ->having('distance', '<', $radius)
                ->orderBy('distance')
                ->setBindings([$latitude, $longitude, $latitude])
                ->get();

            // 获取每个酒店的第一张图片
            foreach ($hotels as $hotel) {
                $image = DB::table('hotel_images')
                    ->where('hotel_id', $hotel->id)
                    ->value('image');
                $hotel->image = $image;
            }

            return response()->json($hotels);

        } catch (\Exception $e) {
            \Log::error('GPS 搜索错误:', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => '内部服务器错误',
                'message' => '处理您的请求时发生错误。请重试。'
            ], 500);
        }
    }

}
