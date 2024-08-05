<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(ExpenseSubCategory::class);
    }

}
