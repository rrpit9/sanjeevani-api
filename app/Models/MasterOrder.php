<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function payments()
    {
        return $this->morphMany(MasterPayment::class, 'orderable')->latest('id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'master_order_id','id')->latest('id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
