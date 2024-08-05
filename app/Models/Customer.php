<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'item_id');
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
