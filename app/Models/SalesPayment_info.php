<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SalesPayment_info extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(SalesOrder::class,'order_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($salesPayment) {
            $salesPayment->invoice = static::generateUniqueInvoiceNumber();
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
