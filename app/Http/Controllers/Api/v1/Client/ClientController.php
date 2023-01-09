<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Models\Product;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Http\Resources\v1\BusinessResource;

class ClientController extends Controller
{
    public function dashboard(Request $req)
    {
        $response = (object)[];
        
        return successResponse(
            'Dashboard Info',
            $response
        );
    }

    public function business(Request $req)
    {
        $user = $this->authUser();
        $business = Business::query()->where('client_id',$user->id)->get();
        
        return successResponse(
            'Business', BusinessResource::collection($business)
        );
    }

    public function products(Request $req)
    {
        $user = $this->authUser();

        $product = Product::where(['client_id' => $user->id,'active' => true]);
        if($req->business_id){
            $product = $product->where('business_id', $req->business_id);
        }
        $product = $product->latest('id')->get();

        return successResponse(
            'Business', ProductResource::collection($product)
        );
    }
}
