<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function showRoom(){

        $user = auth()->user();
        $hotels = $user->hotels()->get();
        $rooms = $user->rooms()->get();
        $roomss = $user->rooms()->paginate(10);

        // dd($rooms);

        return view('backend-user.backend-hotel.room',compact('hotels','rooms','roomss'));
    }

    public function addRoom(Request $request){

        $request->validate([
            'name' => 'required|string',
            'type' => 'required',
            'available' => 'required',
            'type' => 'required',
        ]);

        $newRoom = new Room(); // Use a different variable name

        $newRoom->user_id = auth()->id();
        $newRoom->hotel_id = $request->hotel_id;
        $newRoom->name = $request->name;
        $newRoom->type = $request->type;
        $newRoom->available = $request->available;
        $newRoom->price = $request->price;
        $newRoom->save();

        return back()->with('room', 'You have added a new Room successfully');
    }

    public function editRoom($id) {

        $user = auth()->user();
        $hotels = $user->hotels()->get();
        $rooms = $user->rooms()->get();

        return view('backend-user.backend-hotel.room', compact('rooms', 'hotels'));
    }

    public function updateRoom(Request $request, $id){

        $rooms = Room::find($id);

        $rooms->hotel_id = $request->hotel_id;
        $rooms->name = $request->name;
        $rooms->type = $request->type;
        $rooms->available = $request->available;
        $rooms->price = $request->price;
        $rooms->save();

        return back()->with('room','This Room has been updated successfully.');
    }

    public function deleteRoom($id){

        Room::where('id',$id)->delete();

        return back()->with('room','This Room has been delete.');
    }

    public function mutlipledeleteroom(Request $request)
    {
        $ids = json_decode($request->input('ids'));

        if (is_array($ids) && count($ids) > 0) {

            Room::whereIn('id', $ids)->delete();

            return back()->with('room', 'Selected Rooms have been deleted successfully!');

        } else {

            return back()->with('rooms', 'Invalid input. No Rooms were deleted.');
        }
    }

    public function changeroomStatus($id)
    {
        $getstatus = Room::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        Room::where('id', $id)->update(['status' => $status]);

        return back()->with(compact('status'));
    }

}
