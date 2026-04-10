<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function view(Request $request)
    {
        dd($request->user()->id);
        // Logic to display the cart view
    }

    public function store(Request $request,Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();

        if($user){
            $cart = $user->cart()->where('product_id', $product->id)->first();
            if($cart){
                $cart->increment('quantity');
            }else{
                $user->cart()->create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        }else{
            // Handle the case when the user is not authenticated
        }
    }

    public function update(Request $request, $cartItemId)
    {
        dd($request->all());
        // Logic to update the quantity of a cart item
    }

    public function destroy($cartItemId)
    {
        // Logic to remove an item from the cart
    }
}
