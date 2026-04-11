<?php

namespace App\Helper;

use Illuminate\Support\Facades\Cookie;

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

    public static function getCookieCartItems()
    {
        $cartItems = [];
        if (request()->hasCookie('cart_items')) {
            $cartItems = json_decode(request()->cookie('cart_items'), true);
        }
        return $cartItems;
    }

    public static function setCookieCartItems(){
        $items = self::getCookieCartItems();
        Cookie::queue('cart_items', json_encode($items), 0);
    }

    public static function saveCookieCartItems()
    {
        $request = request();
       $user = auth()->user();
       $cartItems = self::getCookieCartItems();
       $newCartItems = [];
       foreach ($cartItems as $cartItem) {
        $existingCartItem = $user->cart()->where('product_id', $cartItem['product_id'])->first();
       
       if(!$existingCartItem)   {
        $newCartItems[] = [
            'user_id' => $user->id,
            'product_id' => $cartItem['product_id'],
            'quantity' => $cartItem['quantity'],
        ];
       }
       }

       if(!empty($newCartItems)){
        $user->cart()->createMany($newCartItems);
       }
    }

    public static function moveCartItemsToDb()
    {
        $user = auth()->user();
        $cookieCartItems = self::getCookieCartItems();

        foreach ($cookieCartItems as $cartItem) {
            $existingCartItem = $user->cart()->where('product_id', $cartItem['product_id'])->first();

            if ($existingCartItem) {
                $existingCartItem->quantity += $cartItem['quantity'];
                $existingCartItem->save();
            } else {
                $user->cart()->create([
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ]);
            }
        }

        // Clear the cookie after moving items to the database
        Cookie::queue(Cookie::forget('cart_items'));
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