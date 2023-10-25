<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    public function ponencia()
    {
        return $this->belongsTo(Ponencia::class);
    }
    public function juicio()
    {
        return $this->belongsTo(Juicio::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
