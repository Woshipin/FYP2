<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserContact;
use App\Models\Contact;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Resort;
use App\Models\Hotel;
use Mail;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactReply;
use App\Mail\UserContactReply;

class ContactController extends Controller
{
    public function viewcontact(){

        $contacts = Contact::paginate(10);

        return view('admin.contact',compact('contacts'));
    }

    public function sendReply(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|integer',
            'reply_message' => 'required|string',
        ]);

        // 获取联系人信息（假设你有一个Contact模型）
        $contact = \App\Models\Contact::find($request->contact_id);

        // 发送邮件
        Mail::to('ahpin7762@gmail.com')->send(new ContactReply($contact, $request->reply_message));

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    public function contact(){

        if(Auth::check()){

            return view('frontend-auth.contactus');

        } else {

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function contactus(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'email' => 'string|required|email|max:100|',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        try{

            $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'emailMessage' => $request->message // Renamed variable
            ];

            Mail::send('email.contactemail', $data, function($message) use ($data) {
                $message->to('ahpin7762@gmail.com')
                ->subject($data['subject']);
            });

            return back()->with('success','Your Contact has been successfully');

        }catch(e){

            return back()->with('fail', 'Failed to Contact. Please try again.');

        }

    }

//-------------------------------------------------------- User Contact Hotel Area --------------------------------------------------//

    public function hotelusercontact($id)
    {
        if(Auth::check()){

            $hotels = Hotel::find($id);
            $hotelId = Hotel::find($id);
            // dd($comments);

            return view('frontend-auth.frontend-hotel.hotelusercontact', compact('hotels', 'hotelId'));

        }else{

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

    }

    public function contacthotel(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'email' => 'string|required|email|max:100|',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        try{

            $contact = new UserContact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->ownertype = $request->ownertype;
            $contact->ownername = $request->ownername;
            $contact->phone = $request->phone;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                "ownertype" => $request->ownertype,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'emailMessage' => $request->message // Renamed variable
            ];

            Mail::send('email.usercontactemail', $data, function($message) use ($data) {
                $message->to('ahpin7762@gmail.com')
                ->subject($data['subject']);
            });

            return back()->with('success','Your Contact the hotel owner has been successfully');

        }catch(e){

            return back()->with('fail', 'Failed to Contact. Please try again.');

        }

    }

    public function viewusercontact()
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Get the owner name of the user
        $ownername = $user->name;

        // Retrieve contacts where ownername matches the authenticated user's name
        $userscontacts = UserContact::where('ownername', $ownername)->paginate(10);

        // Use dd() for debugging
        // dd($userscontacts);

        // Return the view with the retrieved contacts
        return view('backend-user.viewusercontact.viewusercontact', compact('userscontacts'));
    }

//-------------------------------------------------------- User Contact Restaurant Area --------------------------------------------------//

    public function restaurantusercontact($id)
    {
        if(Auth::check()){

            $restaurants = Hotel::find($id);
            $restaurantsId = Hotel::find($id);
            // dd($comments);

            return view('frontend-auth.frontend-restaurant.restaurantusercontact', compact('restaurants', 'restaurantsId'));

        }else{

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

    }

    public function contactrestaurant(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'email' => 'string|required|email|max:100|',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        try{

            $contact = new UserContact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->ownertype = $request->ownertype;
            $contact->ownername = $request->ownername;
            $contact->phone = $request->phone;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                "ownertype" => $request->ownertype,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'emailMessage' => $request->message // Renamed variable
            ];

            Mail::send('email.usercontactemail', $data, function($message) use ($data) {
                $message->to('ahpin7762@gmail.com')
                ->subject($data['subject']);
            });

            return back()->with('success','Your Contact the hotel owner has been successfully');

        }catch(e){

            return back()->with('fail', 'Failed to Contact. Please try again.');

        }

    }

    // public function viewrestaurantcontact()
    // {
    //     // Get the currently authenticated user
    //     $user = auth()->user();

    //     // Get the owner name of the user
    //     $ownername = $user->name;

    //     // Retrieve contacts where ownername matches the authenticated user's name
    //     $restaurantscontact = UserContact::where('ownername', $ownername)->get();

    //     // Use dd() for debugging
    //     // dd($hotelscontact);

    //     // Return the view with the retrieved contacts
    //     return view('backend-user.viewusercontact.viewrestaurantcontact', compact('restaurantscontact'));
    // }

//-------------------------------------------------------- User Contact Restaurant Area --------------------------------------------------//

    public function resortusercontact($id)
    {
        if(Auth::check()){

            $resorts = Hotel::find($id);
            $resortId = Hotel::find($id);
            // dd($comments);

            return view('frontend-auth.frontend-resort.resortusercontact', compact('resorts', 'resortId'));

        }else{

            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

    }

    public function contactresort(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'email' => 'string|required|email|max:100|',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }

        try{

            $contact = new UserContact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->ownertype = $request->ownertype;
            $contact->ownername = $request->ownername;
            $contact->phone = $request->phone;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();

            $data = [
                'user_name' => $request->name,
                'email' => $request->email,
                "ownertype" => $request->ownertype,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'emailMessage' => $request->message // Renamed variable
            ];

            Mail::send('email.usercontactemail', $data, function($message) use ($data) {
                $message->to('ahpin7762@gmail.com')
                ->subject($data['subject']);
            });

            return back()->with('success','Your Contact the hotel owner has been successfully');

        }catch(e){

            return back()->with('fail', 'Failed to Contact. Please try again.');

        }

    }

    // public function viewresortcontact()
    // {
    //     // Get the currently authenticated user
    //     $user = auth()->user();

    //     // Get the owner name of the user
    //     $ownername = $user->name;

    //     // Retrieve contacts where ownername matches the authenticated user's name
    //     $resortscontact = UserContact::where('ownername', $ownername)->get();

    //     // Use dd() for debugging
    //     // dd($hotelscontact);

    //     // Return the view with the retrieved contacts
    //     return view('backend-user.viewusercontact.viewresortcontact', compact('resortscontact'));
    // }

    // public function mutlipledeletecontact(Request $request)
    // {

    //     $ids = json_decode($request->input('ids'));

    //     if (is_array($ids) && count($ids) > 0) {

    //         UserContact::whereIn('id', $ids)->delete();

    //         return back()->with('success', 'Selected User Contacts have been deleted successfully!');

    //     } else {

    //         return back()->with('error', 'Invalid input. No Booked Restaurants were deleted.');
    //     }
    // }

    public function CustomerSendReply(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|integer',
            'reply_message' => 'required|string',
        ]);

        $contact = UserContact::find($request->contact_id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact not found.',
            ], 404);
        }

        try {
            Mail::to('ahpin7762@gmail.com')->send(new UserContactReply($contact, $request->reply_message));

            // $contact->email

            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully!',
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function DeleteContact(Request $request, $id)
    {
        $contact = UserContact::find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found.');
        }

        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted successfully.');
    }

}
