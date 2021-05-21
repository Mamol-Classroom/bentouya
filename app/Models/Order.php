<?php

namespace App\Models;

use App\Http\Controllers\OrderController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function get_total_price()
    {
        $order_details = $this->get_order_details();
        $total_price = 0;

        foreach ( $order_details as $order_detail ) {
            $price = $order_detail->price;
            $quantity = $order_detail->quantity;
            $total_price += $price * $quantity;
        }
        return $total_price;
    }

    public function get_order_details()
    {
        $orders_details = OrderDetail::where('order_id',$this->id)->get();

        return $orders_details;
    }
}
