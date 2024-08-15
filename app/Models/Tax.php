<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country_id',
        'name',
        'percentage',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'tax_id');
    }
}
