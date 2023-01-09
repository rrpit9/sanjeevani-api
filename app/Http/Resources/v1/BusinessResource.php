<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'logo' => asset($this->logo),
            'address' => $this->address,
            'pincode' => $this->pincode,
            'business_email' => $this->business_email,
            'business_mobile' => $this->business_mobile,
            'valid_till' => dateCheck($this->valid_till, true),
            'active' => (bool)$this->active,
            'created_at' => dateCheck($this->created_at, true)
        ];
        return $response;
        // return parent::toArray($request);
    }
}
