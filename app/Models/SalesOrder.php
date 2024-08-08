<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SalesOrder extends Model
{
    use HasFactory;
    public function salesInfo()
    {
        return $this->hasMany(SalesPayment_info::class,'order_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->invoice = static::generateUniqueInvoiceNumber();
        });
    }

    private static function generateUniqueInvoiceNumber()
    {
        $invoiceNumber = Str::random(6);

        while (self::where('invoice', $invoiceNumber)->exists()) {
            $invoiceNumber = Str::random(6);
        }

        return $invoiceNumber;
    }
}
    

