<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasemenDetail extends Model
{
    use HasFactory;

    //RELATION
    public function klub() {
        return $this->belongsTo(Klub::class);
    }
}
