<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentInfo extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class);
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
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
}
