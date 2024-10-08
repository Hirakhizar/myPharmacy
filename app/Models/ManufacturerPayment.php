<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerPayment extends Model
{
    use HasFactory;

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
