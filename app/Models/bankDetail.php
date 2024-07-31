<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bankDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'account_no', 'ifsc', 'branch', 'passbook_photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
