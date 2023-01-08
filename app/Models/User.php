<?php

namespace App\Models;

// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ACTIVE = true;
    const INACTIVE = false;

    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    protected static function boot(){
        parent::boot();
        static::created(function ($user) {
            /* Generating Referral Code */
            $user->referral_code = referralCodeGenerate();

            $user->save();
        });
    }

    public function referrer()
    {
        return $this->belongsTo(User::class,'referred_by','id');
    }
}
