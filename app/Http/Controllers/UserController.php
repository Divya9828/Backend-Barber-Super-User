<?php

namespace App\Http\Controllers;
use App\Models\bankDetail;
use App\Models\customer;
use App\Models\shop;
use Illuminate\Support\Facades\Log;

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
        try {

            $userId = auth()->id();

    if (!$userId) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
    
            Log::info('Store method called.');

            \Log::info('Request Data:', $request->all());
    \Log::info('Request Files:', $request->file());
            // Validate the request data
            $validated = $request->validate([
                'fullname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:customer,email',
                'phone_number' => 'required|string|max:15',
                'shop_name' => 'required|string|max:255',
                'shop_location' => 'required|string|max:255',
                'address_street1' => 'required|string',
                'state' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'pincode' => 'required|string|max:10',
                'pan_card_photo' => 'required|file|mimes:jpg,png,jpeg',
                'aadhar_photo' => 'required|file|mimes:jpg,png,jpeg',
                'shop_images.*' => 'file|mimes:jpg,png,jpeg',
                'account_no' => 'required|string|max:20',
                'ifsc' => 'required|string|max:11',
                'branch' => 'required|string|max:255',
                'passbook_photo' => 'required|file|mimes:jpg,png,jpeg',
            ]);
            Log::info('Validation passed.');
             // Process and store images
             $shopImages = [];
            if ($request->hasFile('shop_images')) {
                foreach ($request->file('shop_images') as $file) {
                    $shopImages[] = $file->store('uploads/shop_images');
                }
            }

            $paths = [];

            if ($request->hasFile('pan_card_photo')) {
                $paths['pan_card_photo'] = $request->file('pan_card_photo')->store('uploads/pan_cards', 'public');
            }

            if ($request->hasFile('aadhar_photo')) {
                $paths['aadhar_photo'] = $request->file('aadhar_photo')->store('uploads/aadhar_cards', 'public');
            }

          

            if ($request->hasFile('passbook_photo')) {
                $paths['passbook_photo'] = $request->file('passbook_photo')->store('uploads/passbooks', 'public');
            }

            // Insert into the customers table
            $user = customer::create([
                'fullname' => $validated['fullname'],
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
            ]);

            // Use authenticated user ID
            $userId = auth()->id();
            Log::info('Authenticated user ID: ' . $userId);

            if (is_null($userId)) {
                Log::error('User not authenticated.');
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            shop::create([
                'user_id' => $userId,
                'shop_name' => $validated['shop_name'],
                'shop_location' => $validated['shop_location'],
                'address_street1' => $validated['address_street1'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'pincode' => $validated['pincode'],
                'pan_card_photo' => $paths['pan_card_photo'],
                'aadhar_photo' => $paths['aadhar_photo'],
               'shop_images' => json_encode($shopImages), // Validate each image file
            ]);

           

            bankDetail::create([
                'user_id' => $user->id,
                'account_no' => $validated['account_no'],
                'ifsc' => $validated['ifsc'],
                'branch' => $validated['branch'],
                'passbook_photo' => $paths['passbook_photo'],
            ]);

            return response()->json(['message' => 'User and associated details created successfully.']);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error creating user: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return a JSON response with the error message
            return response()->json(['error' => 'An error occurred while creating the user.'], 500);
        }
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
