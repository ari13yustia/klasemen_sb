<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasemen extends Model
{
    use HasFactory;

    //RELATION
    public function klasemen_detail() {
        return $this->hasMany(KlasemenDetail::class);
    }
}
