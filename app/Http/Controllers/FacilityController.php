<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resort;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function ShowFacilities()
    {
        $facilities = Facility::orderBy('display_order')->get();
        return view('admin.facility', compact('facilities'));
    }

    public function AddFacilities(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'charge_type' => 'required|in:free,additional_charge,none',
            'display_order' => 'required|integer'
        ]);

        Facility::create($validated);

        return redirect()->back()->with('success', 'Facility added successfully');
    }

    public function DeleteFacilities(Facility $facility)
    {
        $facility->delete();
        
        return redirect()->back()->with('success', 'Facility deleted successfully.');
    }

}
