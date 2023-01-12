<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE = true;
    const INACTIVE = false;

    protected $guarded = [];

    public function client_info()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function business_info()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }
}
