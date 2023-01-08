<?php

namespace App\Models;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Config extends Model
{
    use HasFactory, SoftDeletes;
    
    // Config keys
    const MASTER_PASSWORD = 'MASTER_PASSWORD';
    const REFERRER_BONUS = 'REFERRER_BONUS';

    protected $guarded = [];

    public static function getMasterPassword()
    {
        $config = Config::firstOrCreate(['config_key' => Config::MASTER_PASSWORD],
            [
                'config_value' => Hash::make('xbkJyuTgeFr@3'),
                'description' => 'This Hashed Value is Used For Applying the Master Password'
            ]
        );
        return $config;
    }

    public static function getReferrerBonusPoint()
    {
        $config = Config::firstOrCreate(['config_key' => Config::REFERRER_BONUS],
            [
                'config_value' => '0',
                'description' => 'This Value is Indicates that how much point will ear every referrers'
            ]
        );
        return $config;
    }
}
