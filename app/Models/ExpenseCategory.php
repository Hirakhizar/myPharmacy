<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    public function subcategory(){
        return $this->hasMany(ExpenseSubCategory::class,'category_id');
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
