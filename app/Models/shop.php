<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shop extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shop_name', 'shop_location', 'address_street1', 'state', 'country', 'pincode', 'pan_card_photo', 'aadhar_photo', 'shop_images'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
