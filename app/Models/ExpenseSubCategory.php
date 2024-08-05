<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSubCategory extends Model
{
    use HasFactory;
    public function category(){
       
            return $this->belongsTo(ExpenseCategory::class,'category_id');
        
    }
    public function expense()
    {
        return $this->belongsTo(Expense::class,'subcategory_id');
    }
}
