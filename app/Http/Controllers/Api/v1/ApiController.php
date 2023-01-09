<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\NotificationResource;

class ApiController extends Controller
{
    public function category(Request $req)
    {
        $category = Category::whereActive(true)->get();
        
        return successResponse(
            'Category', CategoryResource::collection($category)
        );
    }

    public function notification(Request $req)
    {
        $user = $this->authUser();
        $notification = Notification::where('user_id',$user->id)->latest('id')->limit(50)->get();
        
        return successResponse(
            'Notification', NotificationResource::collection($notification)
        );
    }
}
