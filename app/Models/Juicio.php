<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juicio extends Model
{
    use HasFactory;

    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }
}
