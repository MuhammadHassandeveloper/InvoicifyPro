<?php
namespace App\Helpers;

use App\Models\SiteSetting;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;


class AppHelper
{

    public static function stripe_publich_key()
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->stripe_publish_key;
    }

    public static function RESEND_API_KEY()
    {
        return 'RESEND_API_KEY=re_bBYchSmc_6v4SYvR8rKR1BVRQpF55HTb3';
    }

    public static function stripe_secret_key()
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->stripe_secret_key;
    }


    public static function site_name()
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->site_name;
    }
    public static function develop_by()
    {
        return 'CodeFlex';
    }

    public static function white_logo()
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->site_white_logo;
    }

    public static function dark_logo()
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->site_dark_logo;
    }



    public static function fav_icon()
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->site_fav_icon;
    }


    public static function appCurrencySign(): string
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->currency_sign;
    }

    public static function appCurrencyCode(): string
    {
        $siteSettings = SiteSetting::first();
        return $siteSettings->currency_code;
    }

    public static function storeActivity($user_id, $action, $details)
    {
        foreach ($details as $key => $value) {
            if (str_ends_with($key, '_id')) {
                unset($details[$key]);
            }
        }

        unset($details['_token']);
        unset($details['_method']);

        $store = DB::table('activity_logs')->insert([
            'user_id' => $user_id,
            'action' => $action,
            'details' => json_encode($details),
            'created_at' => Date::now(),
        ]);

        return $store;
    }


}
