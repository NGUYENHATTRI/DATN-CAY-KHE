<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;
    protected $primaryKey = 'code';
    public $incrementing = false;
    public function districts(){
        return $this->hasMany(Districts::class, 'code');
    }
}
