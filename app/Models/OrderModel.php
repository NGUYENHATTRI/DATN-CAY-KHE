<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    public $table = "order";

    protected $primaryKey = 'orderID';
    public $fillable = [
        'total_ammount',
        'user_id',
        'order_date',
        'coupon_id',
        'order_status',
        'shipment_status',
        'rating',
        'payment_method',
        'payment_id',
        'lading_id',
        'name',
        'phone',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'note',
        'coupon_discount_amount',
    ];
    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo(Provinces::class, 'province_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(Districts::class, 'district_id', 'code');
    }

    public function ward()
    {
        return $this->belongsTo(Wards::class, 'ward_id', 'code');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderDetailModel::class, 'order_id')
            ->with(['product', 'product_variation']);
    }
}
