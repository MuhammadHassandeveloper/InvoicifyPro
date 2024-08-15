<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'country_id',
        'stripe_customer_id',
        'email',
        'password',
        'permissions',
        'last_login',
        'first_name',
        'last_name',
        'phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_phone',
        'status',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'customer_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoicesItems::class, 'customer_id');
    }
}
