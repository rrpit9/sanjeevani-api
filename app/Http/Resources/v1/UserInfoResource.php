<?php

namespace App\Http\Resources\v1;

use App\Models\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => dateCheck($this->email_verified_at, true),
            'profile_image' => url('').'/'.$this->image,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'dob' => dateCheck($this->dob),
            'marital' => $this->marital,
            'aniversary' => dateCheck($this->aniversary),
            'referral_code' => $this->referral_code,
            'active' => (boolean)$this->active
        ];
        // Sending AccessToken at the Time of Login
        if($this->accessToken){
            $response['token_type'] = $this->accessToken['token_type'];
            $response['token_id'] = $this->accessToken['token_id'];
            $response['access_token'] = $this->accessToken['access_token'];
        }
        return $response;
        // return parent::toArray($request);
    }
}
