<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'iso_code', 'currency_sign', 'currency_code','status',];

    public function taxes()
    {
        return $this->hasMany(Tax::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


}
