<?php

namespace App\Helper;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    public static function getCount()
    {
        if ($user = auth()->user()) {
            return $user->cart()->count();
        }else{
            $cartItems = [];
            if (request()->hasCookie('cart_items')) {
                $cartItems = json_decode(request()->cookie('cart_items'), true);
            }
            // array count 
            $skuCount = count($cartItems);
            return $skuCount;
        }
    }

    public static function getCartItems()
    {
        if ($user = auth()->user()) {
            return $user->cart()->with('product')->get()
                ->map(function ($cartItem) {
                    return [
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'title' => $cartItem->product->title ?? 'Unknown Product',
                        'image' => $cartItem->product->product_images[0]['image'] ?? null,
                        'price' => $cartItem->product->price ?? 0,
                    ];
                });
        }else{
            $cartItems = [];
            if (request()->hasCookie('cart_items')) {
                $cartItems = json_decode(request()->cookie('cart_items'), true);
            }
            $cartItems = array_map(function ($cartItem) {
                return [
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'title' => $cartItem['title'] ?? 'Unknown Product',
                    'image' => $cartItem['image'] ?? null,
                    'price' => $cartItem['price'] ?? 0,

                ];
            }, $cartItems);
            return $cartItems;
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

    public static function setCookieCartItems(array $item)
    {

        // $items = self::getCookieCartItems();
        // Cookie::queue('cart_items', json_encode($items), 0);
        Cookie::queue('cart_items', json_encode($item), 43200);
    }

    public static function saveCookieCartItems()
    {
        $user = auth()->user();
        $userCartItems = CartItem::where(['user_id' => $user->id])->get()->keyBy('product_id');
        $savedCartItems = [];

        foreach (self::getCookieCartItems() as $cartItem) {
            if (isset($userCartItems[$cartItem['product_id']])) {
                $userCartItems[$cartItem['product_id']]->update([
                    'quantity' => $userCartItems[$cartItem['product_id']]->quantity + $cartItem['quantity'],
                ]);
                continue;
            }
            $savedCartItems[] = [
                'user_id' => $user->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
            ];
        }
        Cookie::queue(Cookie::forget('cart_items'));
        if (!empty($savedCartItems)) {
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

            if (!empty($newCartItems)) {
                CartItem::insert($newCartItems);
            }
        }
    }

    public static function getProductsAndCartItems()
    {
        $skuItems = self::getCartItems();
        $skuCount = self::getCount();
        return [
            'skuItems' => $skuItems,
            'skuCount' => $skuCount,
        ];
    }
}

