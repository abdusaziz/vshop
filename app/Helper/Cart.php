<?php

namespace App\Helper;

use App\Models\CartItem;
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
        // $items = self::getCookieCartItems();
        // Cookie::queue('cart_items', json_encode($items), 0);
        Cookie::queue('cart_items', fn(int $carry,array $item)=> $carry + $item['quantity'], 0);
    
    }

    public static function saveCookieCartItems()
    {
        $user = auth()->user();
        $userCartItems = CartItem::where(['user_id' => $user->id])->get()->keyBy('product_id');
        $savedCartItems = [];

        foreach(self::getCookieCartItems() as $cartItem) {
            if(isset($userCartItems[$cartItem['product_id']])) {
                $userCartItems[$cartItem['product_id']]->update([
                    'quantity' => $cartItem['quantity']]);
                continue;
            } 
                $savedCartItems[] = [
                    'user_id' => $user->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];            
        }
        if(!empty($savedCartItems)){
            CartItem::insert($savedCartItems);
        } 

    //     $request = request();
    //    $user = auth()->user();
    //    $cartItems = self::getCookieCartItems();
    //    $newCartItems = [];
    //    foreach ($cartItems as $cartItem) {
    //     $existingCartItem = $user->cart()->where('product_id', $cartItem['product_id'])->first();
       
    //    if(!$existingCartItem)   {
    //     $newCartItems[] = [
    //         'user_id' => $user->id,
    //         'product_id' => $cartItem['product_id'],
    //         'quantity' => $cartItem['quantity'],
    //     ];
    //    }
    //    }

    //    if(!empty($newCartItems)){
    //     $user->cart()->createMany($newCartItems);
    //    }
    }

    public static function moveCartItemsToDb()
    {
        $request = request();
        $CartItems = self::getCookieCartItems();
        $newCartItems = [];
            $user = auth()->user();

        foreach ($CartItems as $cartItem) {
            $existingCartItem = $user->cart()->where('product_id', $cartItem['product_id'])->first();

            if (!$existingCartItem) {
                $newCartItems[] = [
                    'user_id' => $user->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];
            } 

            if(!empty($newCartItems)){
                CartItem::insert($newCartItems);
            }
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