<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    protected static function boot(){
        parent::boot();

        static::created(function ($business) {
            /* Default Business Valid Till */
            $business->valid_till = date('Y-m-d',strtotime('+365 days')).' 23:59:59';
            $business->save();
        });
    }

    public function client_info()
    {
        return $this->belongsTo(User::class,'client_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
