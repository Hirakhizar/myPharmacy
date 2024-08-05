<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\Exceptions\PublicPropertyNotFoundException;

class Manufacturer extends Model
{
    use HasFactory;
    protected $fillable = ['state','country','city'];
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

}
