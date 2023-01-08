<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const CLIENT = 2;
    const CUSTOMER = 3;

    protected $guarded = [];
}
