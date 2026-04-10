<?php

namespace App\Helper;

class Cart
{
    public static function getCount()
    {
        if($user = auth()->user()){
            return $user->cart()->sum('quantity');
        }
    }

    public static function getCartItems()
    {
        if($user = auth()->user()){
            return $user->cart()->with('product')->get()
                ->map(function($cartItem){
                    return [
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                    ];
                });
        }
    }


    public static function addToCart($productId, $quantity = 1)
    {
        // Logic to add a product to the cart
    }

    public static function updateCartItem($cartItemId, $quantity)
    {
        // Logic to update the quantity of a cart item
    }

    public static function removeFromCart($cartItemId)
    {
        // Logic to remove an item from the cart
    }
}