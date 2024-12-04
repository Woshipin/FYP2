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

    public function AllResort()
    {
        $resort = Resort::with('images')->where('register_status', 1)->get();
        $resortRatings = [];

        foreach ($resort as $r) {
            $ratings = $r->ratings;
            $averageRating = $ratings->avg('rating') ?? 0; // 如果没有评分，默认为 0
            $resortRatings[$r->id] = [
                'averageRating' => $averageRating,
                'count' => $ratings->count()
            ];
        }

        // 确保 $resort 是一个数组
        $resortArray = $resort->toArray();

        return view('frontend-auth.frontend-resort.resort', compact('resort','resortArray', 'resortRatings'));
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

    // public function uploadAndSearch(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     $image = $request->file('image');
    //     $matchedResorts = $this->findMatchingResorts($image);

    //     return response()->json($matchedResorts);
    // }

    // private function findMatchingResorts($image)
    // {
    //     // 你的图片匹配逻辑
    //     // 示例：通过图片名匹配
    //     $imageName = $image->getClientOriginalName();

    //     // 假设 Resort 模型中有一个 image 字段存储图片名
    //     return Resort::where('image', $imageName)->get();
    // }

    // New
    // public function uploadAndSearch(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    //     try {
    //         $image = $request->file('image');
    //         $matchedResorts = $this->findMatchingResorts($image);
    //         \Log::info('Matched resorts:', $matchedResorts);
    //         return response()->json($matchedResorts);
    //     } catch (\Exception $e) {
    //         \Log::error('Error in uploadAndSearch:', ['error' => $e->getMessage()]);
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // private function findMatchingResorts($image)
    // {
    //     $hasher = new ImageHash(new DifferenceHash());
    //     $uploadedImagePath = $image->getRealPath();
    //     if (!file_exists($uploadedImagePath)) {
    //         \Log::error('Uploaded image file does not exist: ' . $uploadedImagePath);
    //         throw new \Exception('Uploaded image file does not exist');
    //     }
    //     $uploadedImageHash = $hasher->hash($uploadedImagePath);
    //     $resortImages = ResortImage::all();
    //     $matchedResortIds = [];
    //     $threshold = 10;

    //     foreach ($resortImages as $resortImage) {
    //         $dbImagePath = public_path('images/' . $resortImage->image);
    //         if (!file_exists($dbImagePath)) {
    //             \Log::warning('Database image file does not exist: ' . $dbImagePath);
    //             continue;
    //         }
    //         try {
    //             $dbImageHash = $hasher->hash($dbImagePath);
    //             $distance = $hasher->distance($uploadedImageHash, $dbImageHash);
    //             \Log::info("Image comparison:", [
    //                 'uploaded_image' => $uploadedImagePath,
    //                 'db_image' => $dbImagePath,
    //                 'distance' => $distance
    //             ]);
    //             if ($distance <= $threshold) {
    //                 $matchedResortIds[] = $resortImage->resort_id;
    //             }
    //         } catch (\Exception $e) {
    //             \Log::error('Error processing image: ' . $dbImagePath, ['error' => $e->getMessage()]);
    //         }
    //     }
    //     $matchedResortIds = array_unique($matchedResortIds);
    //     $matchedResorts = Resort::with('images')->whereIn('id', $matchedResortIds)->get();
    //     $matchedResortsArray = $matchedResorts->map(function ($resort) {
    //         $resortArray = $resort->toArray();
    //         $resortArray['images'] = $resort->images->map(function ($image) {
    //             return [
    //                 'id' => $image->id,
    //                 'image' => $image->image,
    //                 'url' => asset('images/' . $image->image)
    //             ];
    //         });
    //         return $resortArray;
    //     })->toArray();
    //     \Log::info('Matched resorts:', $matchedResortsArray);
    //     return $matchedResortsArray;
    // }

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

    // private function findMatchingResorts($image)
    // {
    //     $hasher = new ImageHash(new DifferenceHash());

    //     $uploadedImagePath = $image->getRealPath();
    //     if (!file_exists($uploadedImagePath)) {
    //         \Log::error('Uploaded image file does not exist: ' . $uploadedImagePath);
    //         throw new \Exception('Uploaded image file does not exist');
    //     }

    //     $uploadedImageHash = $hasher->hash($uploadedImagePath);

    //     $resortImages = ResortImage::all();

    //     $matchedResortIds = [];
    //     $threshold = 10; // Increased threshold for more matches

    //     foreach ($resortImages as $resortImage) {
    //         $dbImagePath = public_path('images/' . $resortImage->image); // 确保路径正确
    //         if (!file_exists($dbImagePath)) {
    //             \Log::warning('Database image file does not exist: ' . $dbImagePath);
    //             continue;
    //         }

    //         try {
    //             $dbImageHash = $hasher->hash($dbImagePath);
    //             $distance = $hasher->distance($uploadedImageHash, $dbImageHash);

    //             \Log::info("Image comparison:", [
    //                 'uploaded_image' => $uploadedImagePath,
    //                 'db_image' => $dbImagePath,
    //                 'distance' => $distance
    //             ]);

    //             if ($distance <= $threshold) {
    //                 $matchedResortIds[] = $resortImage->resort_id;
    //             }
    //         } catch (\Exception $e) {
    //             \Log::error('Error processing image: ' . $dbImagePath, ['error' => $e->getMessage()]);
    //         }
    //     }

    //     $matchedResortIds = array_unique($matchedResortIds);
    //     $matchedResorts = Resort::whereIn('id', $matchedResortIds)->get();

    //     \Log::info('Matched resorts:', $matchedResorts->toArray());

    //     return $matchedResorts->toArray();
    // }

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

    // public function gpsSearch(Request $request)
    // {
    //     $latitude = $request->query('latitude');
    //     $longitude = $request->query('longitude');
    //     $radius = 500; // 50 km 范围

    //     try {

    //         $resorts = DB::select(
    //             'SELECT *,
    //             (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
    //             FROM resorts
    //             HAVING distance < ?
    //             ORDER BY distance',
    //             [$latitude, $longitude, $latitude, $radius]
    //         );

    //         return response()->json($resorts);

    //     } catch (\Exception $e) {

    //         return response()->json([
    //             'message' => $e->getMessage(),
    //             'exception' => get_class($e),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTrace()
    //         ], 500);
    //     }
    // }

    public function ResortgpsSearch(Request $request)
    {
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');
        $radius = 150; // 50 km range

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
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('fail', 'You must be logged in to view the community form.');
        }

        // Get the resort communities for the given resort_id and eager load images
        $communities = ResortCommunity::with('multipleImages')->where('resort_id', $id)->get();

        return view('backend-user.backend-resort.resort-community', compact('communities', 'id'));
    }

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

        // Create the community entry in the ResortCommunity table
        $community = ResortCommunity::create([
            'resort_id' => $id,
            'name' => $request->name,
            'category' => $request->category,
            'cultural' => $request->cultural,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
        ]);

        // Handle image uploads and store them in the ResortCommunityMultipleImage table
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePath = $image->store('images', 'public'); // Store the image
                ResortCommunityMultipleImage::create([
                    'community_id' => $community->id, // Associate image with the community
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Community added successfully.');
    }

    // Update a resort community
    public function updateCommunity(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cultural' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        $community = ResortCommunity::findOrFail($id);

        // Handle image uploads
        $imagePaths = json_decode($community->image, true) ?? [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePaths[] = $image->store('images', 'public');
            }
        }

        // Update the community data
        $community->update([
            'name' => $request->name,
            'category' => $request->category,
            'image' => json_encode($imagePaths),
            'cultural' => $request->cultural,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Community updated successfully.');
    }

    // Delete a resort community
    public function deleteCommunity($id)
    {
        $community = ResortCommunity::findOrFail($id);
        $community->delete();

        return redirect()->back()->with('success', 'Community deleted successfully.');
    }

}
