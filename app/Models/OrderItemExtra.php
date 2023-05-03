<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemExtra extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function orderItem(){
        return $this->belongsTo(OrderItem::class);
    }

    public function menuItemExtra(){
        return $this->belongsTo(MenuItemExtra::class);
    }
}
