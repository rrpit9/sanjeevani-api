<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OAuthAccessToken extends Model
{
    use HasFactory;
    
    public $table = 'oauth_access_tokens';

    protected $hidden = ['created_at','updated_at'];

    protected $guarded = [];
}
