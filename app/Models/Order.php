<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchaser_name',
        'purchaser_email',
        'purchaser_address',
        'purchaser_phone',
        'total_amount'
    ];

    public function  items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentInfo()
    {
        return $this->hasOne(PaymentInfo::class);
    }
}
