<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'generic_name',
        'sku',
        'weight',
        'category_id',
        'manufacturer_id',
        'price',
        'manufacturer_price',
        'stock',
        'expire_date',
        'status',

    ];
    public function customers()
    {
        return $this->hasMany(Customer::class,'item_id');
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
