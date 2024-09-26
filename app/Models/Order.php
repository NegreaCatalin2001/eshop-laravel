<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'email',
        'phone',
        'address',
        'city',
        'county',
        'country',
        'postalcode',
        'status',
        'tracking_no',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}
