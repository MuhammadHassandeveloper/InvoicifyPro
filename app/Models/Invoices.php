<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'country_id',
        'stripe_invoice_id',
        'stripe_invoice_number',
        'stripe_invoice_url',
        'stripe_invoice_pdf_url',
        'stripe_customer_id',
        'sub_amount',
        'amount',
        'tax_amount',
        'description',
        'note',
        'period_start',
        'period_end',
        'invoice_paid_date',
        'invoice_paid_time',
        'status',
        'tax_id',
        'charge_id',
        'discount_id',
        'charge_shipping_id',
        'total_tax_amount',
        'total_charge_amount',
        'total_discount_amount',
    ];

    protected $dates = ['period_start', 'period_end', 'invoice_paid_date'];

    protected $with = ['user', 'customer', 'tax', 'discount', 'charge'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function charge()
    {
        return $this->belongsTo(ShippingCharge::class, 'charge_shipping_id');
    }

    public function items()
    {
        return $this->hasMany(InvoicesItems::class, 'invoice_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}

