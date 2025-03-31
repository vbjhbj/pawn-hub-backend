<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Holding;

class Settlement extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function holding()
    {
        return $this->belongsTo(Holding::class);
    }
}
