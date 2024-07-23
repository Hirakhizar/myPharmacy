<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\Exceptions\PublicPropertyNotFoundException;

class Manufacturer extends Model
{
    use HasFactory;
    protected $fillable = ['state','country','city'];
    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'manufacturer_id');
    }

}
