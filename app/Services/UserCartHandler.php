<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use App\Services\Constants\OrderPaymentStatus;

class UserCartHandler
{
    public function __construct(){}

    public function addItemsToCart(Model $item, $quantity = 1, Model $customer)
    {
        $checkWithParameter = [
            'user_id' => $customer->getKey(),
            'client_id' => $item->client_id ?? null,
            'business_id' => $item->business_id ?? null,
            'itemable_type' => $item->getMorphClass(),
            'itemable_id' => $item->getKey(),
            'status' => OrderPaymentStatus::INITIATED,
            'master_order_id' => null
        ];

        // $existCartCheck = Cart::where($checkWithParameter)->latest('id')->first();
        // if($existCartCheck){
        //     $quantity += $existCartCheck->quantity;
        // }

        $discountAmount = round(($item->price * $item->discount) / 100,2);
        $totalPayableAmount = round(($item->price - $discountAmount) * $quantity, 2);

        return Cart::updateOrCreate($checkWithParameter,[
            'price' => round($item->price, 2),
            'discount_amount' => round($discountAmount, 2),
            'quantity' => round($quantity, 2),
            'total_payable_amount' => round($totalPayableAmount, 2),
            'ip' => request()->ip()
        ]);
    }

    /*public function getUserCartInfo($user)
    {
        return Cart::where([
            'user_id' => $user->getKey(),
            'status' => MasterOrderAndCartStatus::INITIATED,
            'master_order_id' => null
        ])->get();
    }*/
}