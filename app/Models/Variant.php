<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $table = 'variant';
    protected $primaryKey = 'variantID';
    protected $fillable = [
        'color',
        'size_id',
        'material_id',
        'stock_quantity',
        'product_id',
        'price',
    ];
    public $timestamps =false;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
