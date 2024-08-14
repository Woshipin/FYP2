<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use App\Models\Deposit;
use App\Models\Refund;
use App\Models\BookingRestaurant;
use App\Models\BookingResort;
use App\Models\BookingHotel;
use App\Models\Table;
use App\Models\Room;
use App\Models\Gender;
use App\Models\User;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Events\BookingStatus;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{

    public function viewdeposit()
    {
        $user = auth()->user();

        $resortnames = $user->resorts()->pluck('name')->toArray();
        $restaurantnames = $user->restaurants()->pluck('name')->toArray();
        $hotelnames = $user->hotels()->pluck('name')->toArray();

        // Combine resort, restaurant, and hotel names into one array
        $typeNames = array_merge($resortnames, $restaurantnames, $hotelnames);

        $userdeposits = Deposit::whereIn('type_name', $typeNames)->paginate(10);

        // Other parts of your code...

        return view('backend-user.deposit.userdeposit', compact('userdeposits'));
    }

    public function deleteDeposit($id){

        Deposit::where('id',$id)->delete();

        return back()->with('success','This Deposit has been delete.');
    }

    public function deleteMultipleDeposit(Request $request)
    {
        $ids = json_decode($request->input('ids')); // Convert JSON string back to array
        Deposit::whereIn('id', $ids)->delete();

        return back()->with('success', 'The selected Deposits have been deleted successfully!');
    }

    public function changedepositStatus($id)
    {
        $getstatus = Deposit::select('status')->where('id', $id)->first();

        if ($getstatus->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }

        // event(new HotelStatus());

        Deposit::where('id', $id)->update(['status' => $status]);

        return back()->with(compact('status'));
    }

    public function DepositSearch(Request $request)
    {
        $user = auth()->user();

        $resortnames = $user->resorts()->pluck('name')->toArray();

        $deposits = Deposit::whereIn('type_name', $resortnames);

        // Paginate the query builder instance
        $userdeposits = $deposits->paginate(10);

        // Build your database query based on the input values
        $query = Deposit::query();

        if ($request->user_name) {
            $query->where('user_name', 'LIKE', '%' . $request->user_name . '%');
        }

        if ($request->card_number) {
            $query->where('card_number', 'LIKE', '%' . $request->card_number . '%');
        }

        if ($request->date) {
            $query->where('date', 'LIKE', '%' . $request->date . '%');
        }

        if ($request->month) {
            $query->where('month', 'LIKE', '%' . $request->month . '%');
        }

        if ($request->year) {
            $query->where('year', 'LIKE', '%' . $request->year . '%');
        }

        // Execute the query and retrieve the results
        $userdeposits = $query->paginate(10);

        // Execute the query
        // $results = $query->get();
        // dd($result);
        // {{ dd($results) }}

        return view('backend-user.deposit.userdeposit', compact('userdeposits'));
    }

    public function refunduserdeposit($id)
    {
        // Retrieve the resort with the given ID from the database
        $userdeposits = Deposit::find($id);

        if (!$userdeposits) {
            // Resort not found, handle the error accordingly (e.g., redirect or show an error message)
            return redirect()->back()->with('error', 'Resort not found.');
        }

        // Pass the resort data to the view
        return view('backend-user.deposit.userdeposit', compact('userdeposits'));
    }

    public function RefundDepositToUser(Request $request, $id){

        $request->validate([
            'card_number' => 'required',
            'card_holder' => 'required',
            'card_month' => 'required',
            'card_year' => 'required',
            'cvv' => 'required',
        ]);

        try{

            $refund = new Refund();
            $refund->customer_name = $request->customer_name;
            $refund->refund_name = $request->refund_name;
            $refund->type_name = $request->type_name;
            $refund->deposit_price = $request->deposit_price;
            $refund->card_number = $request->my_card_number;
            $refund->user_card_number = $request->card_number;
            $refund->card_holder = $request->card_holder;
            $refund->card_month = $request->card_month;
            $refund->card_year = $request->card_year;
            $refund->cvv = $request->cvv;
            $refund->save();

            // 获取与该退款相关联的存款记录
            $deposit = Deposit::where('card_number', $request->card_number)->first();

            if ($deposit) {
                $deposit->status = 1;
                $deposit->save();
            }

            $data = [
                'subject' => 'Refund the ' . $request->type_name . ' Deposit Fee $100',
                'customer_name' => $request->customer_name,
                'refund_name' => $request->refund_name,
                'type_name' => $request->type_name,
                'deposit_price' => $request->deposit_price,
                'user_card_number' => $request->card_number,
                'card_holder' => $request->card_holder,
                'card_month' => $request->card_month,
                'card_year' => $request->card_year,
            ];


            Mail::send('email.refundemail', $data, function($message) use ($data) {
                $message->to('ahpin7762@gmail.com')
                ->subject($data['subject']);
            });

            return back()->with('success', 'Refund created successfully!');

        }catch (Exception $e){

            return back()->with('error', 'Refund Fail!');
        }
    }

    public function viewRefund()
    {
        $user = auth()->user();
        $refundName = $user->name; // Assuming 'owner_name' is a field in the User model.

        $userRefunds = Refund::where('refund_name', $refundName)->paginate(10);

        return view('backend-user.refund.userrefund', compact('userRefunds'));
    }

    public function deleteRefund($id){

        Refund::where('id',$id)->delete();

        return back()->with('success','This Refund has been delete.');
    }

    public function deleteMultipleRefund(Request $request)
    {
        $ids = json_decode($request->input('ids')); // Convert JSON string back to array
        Refund::whereIn('id', $ids)->delete();

        return back()->with('success', 'The selected Refunds have been deleted successfully!');
    }

    public function RefundSearch(Request $request)
    {
        $user = auth()->user();
        $ownerName = $user->name; // Assuming 'owner_name' is a field in the User model.

        $userRefunds = Refund::where('owner_name', $ownerName)->paginate(10);

        // Build your database query based on the input values
        $query = Refund::query();

        if ($request->customer_name) {
            $query->where('customer_name', 'LIKE', '%' . $request->customer_name . '%');
        }

        if ($request->card_number) {
            $query->where('card_number', 'LIKE', '%' . $request->card_number . '%');
        }

        if ($request->date) {
            $query->where('date', 'LIKE', '%' . $request->date . '%');
        }

        if ($request->month) {
            $query->where('month', 'LIKE', '%' . $request->month . '%');
        }

        if ($request->year) {
            $query->where('year', 'LIKE', '%' . $request->year . '%');
        }

        // Execute the query and retrieve the results
        $userRefunds = $query->paginate(10);

        // Execute the query
        // $results = $query->get();
        // dd($result);
        // {{ dd($results) }}

        return view('backend-user.refund.userrefund', compact('userRefunds'));
    }

}
