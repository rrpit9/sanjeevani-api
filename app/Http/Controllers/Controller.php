<?php

namespace App\Http\Controllers;

use App\Models\OAuthAccessToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function authUser()
    {
        return auth()->user();
    }
    
    // Access Token for LoggedIn User Passport
    public function getAccessToken($user)
    {
        $token = $user->createToken('authToken');
        return [
            'access_token' => $token->accessToken,
            'token_id' => $token->token->id ?? null,
            'token_type' => 'Bearer'
        ];
    }

    public function updateDeviceTypeandToken($user, $request)
    {
        if($user->accessToken && $user->accessToken['token_id']){
            $tokenId = $user->accessToken['token_id'];

            OAuthAccessToken::where(['id' => $tokenId,'user_id' => $user->id])->update([
                'device_type'=> ($request->device_type ?? null),
                'device_token'=> ($request->device_token ?? null),
                'ip_address' => request()->ip()
            ]);
        }
    }
}
