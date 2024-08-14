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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate each image
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
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
    public function AllHotel(){

        $hotels = Hotel::with('images')->get();

        return view('frontend-auth.frontend-hotel.hotel',compact('hotels'));
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

        $image = $request->file('image');
        $matchedHotels = $this->findMatchingHotels($image);

        return response()->json($matchedHotels);
    }

    private function findMatchingHotels($image)
    {
        // 你的图片匹配逻辑
        // 示例：通过图片名匹配
        $imageName = $image->getClientOriginalName();

        // 假设 Resort 模型中有一个 image 字段存储图片名
        return Hotel::where('image', $imageName)->get();
    }

}
