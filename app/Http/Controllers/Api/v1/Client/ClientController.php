<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Models\User;
use App\Models\Product;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\UserCartHandler;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Http\Resources\v1\BusinessResource;
use App\Http\Resources\v1\CartInfoResource;

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

    public function addtoCart(Request $req)
    {
        $req->validate([
            'mobile' => 'nullable|digits:10|numeric',
            'product_id' => 'required|min:1|numeric',
            'business_id' => 'required|min:1|numeric',
            'quantity' => 'required|numeric|min:1'
        ]);
        $client = $this->authUser();
        
        $customer = $client;
        
        if(!empty($req->mobile)){
            $customer = User::firstOrCreate(['mobile' => $req->mobile]);
        }

        $searchWith = [
            'id' => $req->product_id,
            'client_id' => $client->id,
            'business_id' => $req->business_id,
            'active' => Product::ACTIVE
        ];
        $product = Product::where($searchWith)->first();
        if(!$product){
            throw new CustomException(['product_id' => __('custom.product_not_found')]);
        }
        /* Add into Cart */
        $cartHandler = new UserCartHandler();
        $item = $cartHandler->addItemsToCart($product, $req->quantity, $customer);

        return successResponse('Item added in cart', new CartInfoResource($item));
    }
}
