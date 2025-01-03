<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resort;
use App\Models\User;
use App\Models\resort_promotion_dates;
use App\Models\ResortDiscount;
use App\Events\HotelStatus;
use App\Models\ResortRating;
use App\Models\ResortImage;
use App\Models\ResortCommunity;
use App\Models\ResortCommunityMultipleImage;
use App\Models\CommunityCategory;
use App\Models\Facility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

use Intervention\Image\Facades\Image;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

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
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
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
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // 验证每个图像
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
    // public function AllResort()
    // {
    //     $resort = Resort::with('images')->get();
    //     return view('frontend-auth.frontend-resort.resort', compact('resort'));
    // }

    // good
    // public function AllResort()
    // {
    //     $resort = Resort::with('images')->where('register_status', 1)->get();

    //     // dd($resort);

    //     $resortRatings = [];

    //     foreach ($resort as $r) {
    //         $ratings = $r->ratings;
    //         $averageRating = $ratings->avg('rating') ?? 0; // 如果没有评分，默认为 0
    //         $resortRatings[$r->id] = [
    //             'averageRating' => $averageRating,
    //             'count' => $ratings->count()
    //         ];

    //         // dd($averageRating);
    //     }

    //     // 确保 $resort 是一个数组
    //     $resortArray = $resort->toArray();

    //     return view('frontend-auth.frontend-resort.resort', compact('resort','resortArray', 'resortRatings'));
    // }

    // public function AllResort()
    // {
    //     // Get all resorts with preloaded relationships
    //     $resort = Resort::with(['images', 'ratings'])
    //         ->where('register_status', 1)
    //         ->get();

    //     $resortRatings = [];

    //     // Calculate average ratings for each resort
    //     foreach ($resort as $r) {
    //         $ratings = $r->ratings;
    //         $averageRating = $ratings->isEmpty() ? 0 : $ratings->avg('rating');

    //         $resortRatings[$r->id] = [
    //             'averageRating' => round($averageRating, 1), // Round to 1 decimal place
    //             'count' => $ratings->count()
    //         ];

    //         // dd($averageRating);
    //     }

    //     // Convert resorts to array for JavaScript use
    //     $resortsArray = $resort->toArray();

    //     // Pass data to view with resortRatings as JSON for JavaScript
    //     return view('frontend-auth.frontend-resort.resort', [
    //         'resort' => $resort,
    //         'resortsArray' => $resortsArray,
    //         'resortRatings' => $resortRatings
    //     ]);
    // }

    // Full SHow All Resort
    public function AllResort()
    {
        // Get all resorts with preloaded images
        $resort = Resort::with(['images'])
            ->where('register_status', 1)
            ->get();

        $resortRatings = [];

        // Calculate average ratings for each resort using Query Builder
        foreach ($resort as $r) {
            // Get ratings using Query Builder
            $ratings = DB::table('resort_ratings')
                ->where('rateable_id', $r->id)
                ->where('rateable_name', $r->name);

            // Calculate average rating
            $averageRating = $ratings->avg('rating') ?? 0;

            // Get rating count
            $ratingCount = $ratings->count();

            $resortRatings[$r->id] = [
                'averageRating' => round($averageRating, 1), // Round to 1 decimal place
                'count' => $ratingCount
            ];
        }

        // Pass data to view with resortRatings as JSON for JavaScript
        return view('frontend-auth.frontend-resort.resort', [
            'resort' => $resort,
            'resortsArray' => $resort->toArray(),
            'resortRatings' => $resortRatings
        ]);

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

        $communitycategorys = CommunityCategory::all();

        // 获取该 resort 的所有 community
        $communities = DB::table('resort_communities')
        ->where('resort_id', $resort->id)
        ->get();

        return view('frontend-auth.frontend-resort.resort-detail', compact('resort', 'averageRating', 'ratingCount', 'singleRating'
            ,'communitycategorys','communities'));
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
        try {
            $image = $request->file('image');
            $matchedResorts = $this->findMatchingResorts($image);
            \Log::info('Matched resorts:', $matchedResorts);
            return response()->json($matchedResorts);
        } catch (\Exception $e) {
            \Log::error('Error in uploadAndSearch:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function findMatchingResorts($image)
    {
        $hasher = new ImageHash(new DifferenceHash());
        $uploadedImagePath = $image->getRealPath();
        if (!file_exists($uploadedImagePath)) {
            \Log::error('Uploaded image file does not exist: ' . $uploadedImagePath);
            throw new \Exception('Uploaded image file does not exist');
        }
        $uploadedImageHash = $hasher->hash($uploadedImagePath);
        $resortImages = ResortImage::all();
        $matchedResortIds = [];
        $threshold = 5; // 调整阈值以提高匹配准确性

        foreach ($resortImages as $resortImage) {
            $dbImagePath = public_path('images/' . $resortImage->image);
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
                    $matchedResortIds[] = $resortImage->resort_id;
                }
            } catch (\Exception $e) {
                \Log::error('Error processing image: ' . $dbImagePath, ['error' => $e->getMessage()]);
            }
        }
        $matchedResortIds = array_unique($matchedResortIds);
        $matchedResorts = Resort::with('images')->whereIn('id', $matchedResortIds)->get();
        $matchedResortsArray = $matchedResorts->map(function ($resort) {
            $resortArray = $resort->toArray();
            $resortArray['images'] = $resort->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => $image->image,
                    'url' => asset('images/' . $image->image)
                ];
            });
            return $resortArray;
        })->toArray();
        \Log::info('Matched resorts:', $matchedResortsArray);
        return $matchedResortsArray;
    }

    // Final Full GPS Search
    public function ResortgpsSearch(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = 15; // 50 km range

        try {
            $resorts = DB::table('resorts')
                ->select('resorts.*',
                    DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance'))
                // ->where('register_status', 1) // 只选择 register_status 为 1 的酒店
                ->having('distance', '<', $radius)
                ->orderBy('distance')
                ->setBindings([$latitude, $longitude, $latitude])
                ->get();

            // Fetch the first image for each resort
            foreach ($resorts as $resort) {
                $image = DB::table('resort_images')
                    ->where('resort_id', $resort->id)
                    ->value('image');
                $resort->image = $image;
            }

            return response()->json($resorts);

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

    // --------------------------------------------------------- Resort Promotion Area  ---------------------------------------------- //

    public function showPromotionForm($id)
    {

        // 检查用户是否已登录
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'You must be logged in to view the promotion form.');
        }

        $user = auth()->user();

        $resort = Resort::findOrFail($id);
        $promotionDates = $resort->promotionDates()
            ->orderBy('date')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->date)->format('F Y');
            });

        return view('backend-user.backend-resort.resort-promotion', compact('resort', 'promotionDates'));
    }

    public function savePromotionDates(Request $request, $id)
    {
        $resort = Resort::findOrFail($id);

        // 验证请求
        $request->validate([
            'promotion_dates' => 'required|array',
            'promotion_dates.*' => 'required|date_format:Y-m-d',
            'promotion_price' => 'required|numeric', // 单一的价格验证规则
        ]);

        try {
            // 开始事务
            DB::beginTransaction();

            // 删除现有的促销日期
            // $resort->promotionDates()->delete();

            // 保存新的促销日期和价格
            foreach ($request->promotion_dates as $date) {
                $resort->promotionDates()->create([
                    'date' => Carbon::parse($date)->format('Y-m-d'),
                    'price' => $request->promotion_price, // 使用单一的价格值
                ]);
            }

            // 提交事务
            DB::commit();

            return redirect()
                ->route('resort.promotion.form', $id)
                ->with('success', 'Promotion dates and prices saved successfully.');

        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();

            return redirect()
                ->route('resort.promotion.form', $id)
                ->with('error', 'Failed to save promotion dates and prices. ' . $e->getMessage());
        }
    }

    public function updatePromotionPrice(Request $request)
    {
        $request->validate([
            'date_id' => 'required|exists:resort_promotion_dates,id',
            'price' => 'required|numeric',
        ]);

        try {
            $promotionDate = resort_promotion_dates::findOrFail($request->date_id);
            $promotionDate->update(['price' => $request->price]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Failed to update promotion price: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function deletePromotionDate($id, Request $request)
    {
        $resort = Resort::findOrFail($id);

        // 获取查询参数中的 date_id
        $dateId = $request->query('date_id');

        if (!$dateId) {
            return redirect()->back()->with('error', 'Date ID is required.');
        }

        try {
            $resort->promotionDates()->where('id', $dateId)->delete();

            return redirect()->back()->with('success', 'Promotion date deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete promotion date.');
        }
    }

    // --------------------------------------------------------- Resort Discount Area  ---------------------------------------------- //
    public function showDiscountForm($id)
    {
        // 检查用户是否已登录
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'You must be logged in to view the discount form.');
        }

        $user = auth()->user();

        // 检查用户是否有权限查看此度假村的折扣信息（可选，视需求而定）
        // if ($user->cannot('view', Resort::find($id))) {
        //     return redirect()->back()->with('fail', 'You are not authorized to view this discount form.');
        // }

        // 获取指定度假村的折扣信息
        $discounts = ResortDiscount::with('resort')->where('resort_id', $id)->get();

        // 渲染视图并传递数据
        return view('backend-user.backend-resort.resort-discount', compact('discounts', 'id'));
    }

    // 保存新的折扣规则
    public function saveDiscountDates(Request $request, $id)
    {
        $request->validate([
            'nights' => 'required|integer|min:1',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        ResortDiscount::create([
            'resort_id' => $id,
            'nights' => $request->nights,
            'discount' => $request->discount,
        ]);

        return redirect()->back()->with('success', 'Discount added successfully.');
    }

    // 更新折扣规则
    public function updateDiscountPrice(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:resort_discounts,id',
            'nights' => 'required|integer|min:1',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        $discount = ResortDiscount::findOrFail($request->id);
        $discount->update([
            'nights' => $request->nights,
            'discount' => $request->discount,
        ]);

        return redirect()->back()->with('success', 'Discount updated successfully.');
    }

    // 删除折扣规则
    public function deleteDiscountDate($id)
    {
        $discount = ResortDiscount::findOrFail($id);
        $discount->delete();

        return redirect()->back()->with('success', 'Discount deleted successfully.');
    }

    // --------------------------------------------------------- Resort Community Area  ---------------------------------------------- //
    // Show the community form
    public function showCommunityForm($id)
    {
        // 确保用户已登录
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'You must be logged in to view the community form.');
        }

        // 获取指定 resort_id 的所有社区，并预加载 multipleImages
        $communities = ResortCommunity::with('multipleImages')->where('resort_id', $id)->get();

        $communitycategorys = CommunityCategory::all();

        // 返回视图并传递数据
        return view('backend-user.backend-resort.resort-community', compact('communities', 'id','communitycategorys'));
    }

    // public function showCommunityForm($id)
    // {
    //     // 确保用户已登录
    //     if (!auth()->check()) {
    //         return redirect()->route('login')->with('fail', 'You must be logged in to view the community form.');
    //     }

    //     // 获取指定 resort_id 的所有社区，并预加载 multipleImages
    //     $communities = ResortCommunity::with('multipleImages')->where('resort_id', $id)->get();

    //     // 为每个社区的图片生成完整 URL，并格式化成数组
    //     $communities->each(function ($community) {
    //         $community->imageUrls = $community->multipleImages->pluck('image_path')->map(function ($imagePath) {
    //             return asset('images/' . $imagePath);
    //         })->toArray(); // 转换成数组形式
    //     });

    //     // 返回视图并传递数据
    //     return view('backend-user.backend-resort.resort-community', compact('communities', 'id'));
    // }

    // Save a new resort community
    public function saveCommunity(Request $request, $id)
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
        $community = new ResortCommunity();
        $community->resort_id = $id;
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

                // 保存到 ResortCommunityMultipleImage 表
                $communityImage = new ResortCommunityMultipleImage();
                $communityImage->community_id = $community->id;
                $communityImage->image_path = 'images/' . $imageName; // 保存完整路径
                $communityImage->save();
            }
        }

        return redirect()->back()->with('success', 'Community added successfully.');
    }

    // Update a resort community
    public function updateCommunity(Request $request, $id)
    {
        $community = ResortCommunity::findOrFail($id);

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

    // Delete a resort community
    public function deleteCommunity($id)
    {
        // Find the community by id
        $community = ResortCommunity::findOrFail($id);

        // Delete the community
        $community->delete();

        // Redirect with success message
        return redirect()->back()->with('success', 'Community deleted successfully.');
    }

    public function CommunityImageDestroy($id)
    {
        $image = ResortCommunityMultipleImage::findOrFail($id);

        // 删除图片文件
        $imagePath = public_path('images/' . $image->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // 从数据库中删除记录
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully.']);
    }

    // --------------------------------------------------------- Resort Facilities Area  ---------------------------------------------- //
    public function showResortFacilities($resortId)
    {
        // 确保用户已登录
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'You must be logged in to view the community form.');
        }

        $facilities = Facility::all();
        $resort = Resort::find($resortId);

        // 获取当前度假村已经选中的设施
        $selectedFacilities = $resort->facilities()->pluck('facilities.id')->toArray();

        return view('backend-user.backend-resort.resort-facility', compact('facilities', 'resort', 'selectedFacilities'));
    }

    public function addResortFacilities(Request $request, $resortId)
    {
        $resort = Resort::find($resortId);
        $selectedFacilities = $request->input('facilities', []);

        // 假设你有一个关联表来存储度假村和设施的关系
        $resort->facilities()->sync($selectedFacilities);

        return redirect()->back()->with('success', 'Facilities added successfully.');
    }

    public function showResortCommunityDetail($id) {

        $community = ResortCommunity::find($id);

        return view('frontend-auth.frontend-resort.resort-community-detail', compact('community'));
    }

}
