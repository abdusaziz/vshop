<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::with('category','brand','product_images')->orderBy('id','desc')->limit(8)->get();
        return inertia('User/Home', [
            'products'=>$products,
            'canLogin' => app('router')->has('login'),
            'canRegister' => app('router')->has('register'),
        ]);
    }
}
