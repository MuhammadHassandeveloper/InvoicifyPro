<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'site_fav_icon',
        'site_white_logo',
        'site_dark_logo',
        'stripe_publish_key',
        'stripe_secret_key',
        'currency_sign',
        'currency_code'
    ];
}
