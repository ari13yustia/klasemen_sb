<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klub extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates =['deleted_at'];

    protected $fillable = [
        'nama',
        'kota',
    ];

    //RELATION
    public function klasemen() {
        return $this->hasMany(Klasemen::class);
    }

    public function klasemen_detail() {
        return $this->hasMany(KlasemenDetail::class);
    }
}
