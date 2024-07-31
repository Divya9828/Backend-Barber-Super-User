<?php

namespace App\Http\Controllers;
use App\Models\bankDetail;
use App\Models\customer;
use App\Models\shop;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'shop_name' => 'required|string|max:255',
            'shop_location' => 'required|string|max:255',
            'address_street1' => 'required|string',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'pan_card_photo' => 'required|file|mimes:jpg,png,jpeg',
            'aadhar_photo' => 'required|file|mimes:jpg,png,jpeg',
            'shop_images' => 'required|array',
            'shop_images.*' => 'file|mimes:jpg,png,jpeg',
            'account_no' => 'required|string|max:20',
            'ifsc' => 'required|string|max:11',
            'branch' => 'required|string|max:255',
            'passbook_photo' => 'required|file|mimes:jpg,png,jpeg',
        ]);

        // Insert into the users table
        $user = customer::create([
            'fullname' => $validated['fullname'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
        ]);

        // Handle file uploads and insert into the shops table
        $panCardPhotoPath = $request->file('pan_card_photo')->store('pan_cards');
        $aadharPhotoPath = $request->file('aadhar_photo')->store('aadhar');
        $shopImagesPaths = [];
        if ($request->hasFile('shop_images')) {
            foreach ($request->file('shop_images') as $image) {
                $shopImagesPaths[] = $image->store('shop_images');
            }
        }
        
        Shop::create([
            'user_id' => $user->id,
            'shop_name' => $validated['shop_name'],
            'shop_location' => $validated['shop_location'],
            'address_street1' => $validated['address_street1'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'pincode' => $validated['pincode'],
            'pan_card_photo' => $panCardPhotoPath,
            'aadhar_photo' => $aadharPhotoPath,
            'shop_images' => json_encode($shopImagesPaths),
        ]);

        // Handle file upload and insert into the bank_details table
        $passbookPhotoPath = $request->file('passbook_photo')->store('passbooks');
        
        BankDetail::create([
            'user_id' => $user->id,
            'account_no' => $validated['account_no'],
            'ifsc' => $validated['ifsc'],
            'branch' => $validated['branch'],
            'passbook_photo' => $passbookPhotoPath,
        ]);

        return response()->json(['message' => 'User and associated details created successfully.']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
