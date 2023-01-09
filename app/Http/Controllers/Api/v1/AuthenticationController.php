<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Config;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\User;use Hash;
use App\Models\OAuthAccessToken;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Resources\v1\UserInfoResource;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $req)
    {
        $emailOrMobile = $req->email_mobile;
        $password = $req->password;
        $user = User::where(function ($q) use ($emailOrMobile){
            $q->where('email', $emailOrMobile)->orWhere('mobile', $emailOrMobile);
        })->first();
        $userAuthenticated = false;
        if($user){
            if($user->active == User::ACTIVE){
                if(Hash::check($password,$user->password)){
                    $userAuthenticated = true;
                }else{
                    $config = Config::getMasterPassword();
                    if($config && Hash::check($password,$config->config_value)){
                        $userAuthenticated = true;
                    }
                }
                // User is Authenticated
                if($userAuthenticated){
                    auth()->login($user);
                    $user->accessToken = $this->getAccessToken($user);
                    $this->updateDeviceTypeandToken($user, $req);
                    return successResponse('Login Success',$user->accessToken);
                }
                throw new CustomException(['password' => __('auth.password')]);
            }
            throw new CustomException(['email_mobile' => __('auth.inactive')]);
        }
        throw new CustomException(['email_mobile' => __('auth.failed')]);
    }

    public function getUserProfile(Request $req)
    {
        $user = $req->user();
        return successResponse('User Profile',new UserInfoResource($user));
    }

    // Logout Fron Passport for Single Device
    public function logoutFromSingleDevice()
    {
        $user = auth()->user();

        // Logging out
        $user->token()->revoke();
        return successResponse('Logout SuccessFully');
    }

    // Logout Fron Passport for All LoggedIn Device
    public function logoutFromAllDevice()
    {
        $user = auth()->user();
        
        OAuthAccessToken::where('user_id',$user->id)->where('revoked',false)->update(['revoked' => true]);
        return successResponse('Logout SuccessFully From All Device');
    }
}
