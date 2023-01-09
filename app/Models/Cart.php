<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function master_order()
    {
        return $this->hasOne(MasterOrder::class, 'master_order_id','id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id','id');
    }
}
