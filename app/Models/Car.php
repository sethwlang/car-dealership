<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['manufacturer_id', 'model', 'year'];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}