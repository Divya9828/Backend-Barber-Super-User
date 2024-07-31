<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $fillable = ['fullname', 'firstname', 'lastname', 'email', 'phone_number'];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(BankDetail::class);
    }
}
