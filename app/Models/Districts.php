<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
      protected $primaryKey = 'code';
    public $incrementing = false;
     public function provinces(){
        return $this->belongsTo(Provinces::class, 'code');
    }

    public function wards(){
        return $this->hasMany(Wards::class, 'code');
    }
}
