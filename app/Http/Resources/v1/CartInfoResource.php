<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CartInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item = $this->itemable;
        $response = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
            'business_id' => $this->business_id,
            'itemable_type' => $this->itemable_type,
            'itemable_id' => $this->itemable_id,
            'item_name' => $item->name,
            'item_image' => asset($item->image),
            'status' => $this->status,
            'price' => $this->price,
            'discount_amount' => $this->discount_amount,
            'quantity' => $this->quantity,
            'total_payable_amount' => $this->total_payable_amount,
            'master_order_id' => $this->master_order_id,
            'ip' => $this->ip,
            'created_at' => dateCheck($this->created_at,true)
        ];
        return $response;
        // return parent::toArray($request);
    }
}
