<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand_id',
        'category_id',
        'price',
        'image',
        'description',
        'status',
        'available_stock',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoicesItems::class, 'product_id');
    }


    // Method to count out of stock products
    public static function countOutOfStock()
    {
        return self::where('available_stock', 0)->count();
    }

    // Method to count low stock products (stock <= 10)
    public static function countLowStock()
    {
        return self::where('available_stock', '<=', 10)->count();
    }

    // Method to count active products (status = 1)
    public static function countActive()
    {
        return self::where('status', 1)->count();
    }

    // Method to count disabled products (status = 0)
    public static function countDisabled()
    {
        return self::where('status', 0)->count();
    }
}
