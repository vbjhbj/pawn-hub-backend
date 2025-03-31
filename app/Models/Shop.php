<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settlement;


class Shop extends Model
{
    use HasFactory;

    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }
}
