<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
        protected $primaryKey = 'code';
    public $incrementing = false;

    public function districts(){
        return $this->belongsTo(Districts::class, 'code');
    }

    public function providers(){
        return $this->hasMany(User::class);
    }
}
