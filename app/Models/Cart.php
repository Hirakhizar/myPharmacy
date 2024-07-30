<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'item_id');
    }

    public function item(){
        return $this->hasMany(SalesOrderItem::class,'cart_id');
    }
}
