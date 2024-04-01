<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product';
    protected $primaryKey = 'productID';
    protected $fillable = [
        'name',
        'description',
        'thumnail',
        'category_id',
    ];
    // public $timestamps =false;

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function variations()
    {
        return $this->hasMany(Variant::class, 'product_id');
    }
    public function scopeSlug($query, $value)
    {
        return $query->where('slug', $value);
    }
    

}