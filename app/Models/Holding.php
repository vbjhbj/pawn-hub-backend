<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settlement;


class Holding extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function settlement()
    {
        return $this->hasMany(Settlement::class);
    }
}

