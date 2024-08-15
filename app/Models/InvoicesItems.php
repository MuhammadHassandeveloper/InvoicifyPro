<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'stripe_customer_id',
        'stripe_invoice_id',
        'product_id',
        'product_amount',
        'product_quantity',
        'product_description',
    ];

    protected $with = ['invoice', 'customer', 'product'];

    // Relationship with Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'invoice_id');
    }

    // Relationship with User (Customer)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
