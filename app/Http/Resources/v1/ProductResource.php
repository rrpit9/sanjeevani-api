<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'business_id' => $this->business_id,
            'image' => asset($this->image),
            'name' => $this->name,
            'price' => moneyFormat($this->price),
            'discount' => moneyFormat($this->discount).' %',
            'discounted_price' => moneyFormat($this->price - ($this->price * ($this->discount / 100)), 2),
            'description' => $this->description,
            'expiry' => dateCheck($this->expiry),
            'active' => (bool)$this->active,
            'created_at' => dateCheck($this->created_at,true)
        ];

        return $response;
        // return parent::toArray($request);
    }
}
