<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    use HasFactory;
    public $table="order_detail";
    protected $primaryKey = 'order_detailID';
    public $fillable=[
        'product_id',
        'quantity',
    ];
    public $timestamps =false;
    public function product_variation()
    {
        return $this->belongsTo(Variant::class,'product_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
