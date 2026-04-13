<?php

namespace App\Http\Controllers\User;

use App\Helper\Cart;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
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

    public function store(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();

        if ($user) {
            $cart = $user->cart()->where('product_id', $product->id)->first();
            if ($cart) {
                $cart->increment('quantity');
            } else {
                $user->cart()->create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        } else {
            $cartItems = Cart::getCookieCartItems();
            $isProductExist = false;
            foreach ($cartItems as &$cartItem) {
                if ($cartItem['product_id'] == $product->id) {
                    $cartItem['quantity'] += $quantity;
                    $isProductExist = true;
                    break;
                }
            }
            if (!$isProductExist) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
                Cart::setCookieCartItems($cartItems);
            }
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
    }

    public function update(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $user = $request->user();
        if ($user) {
            $cartItem = $user->cart()->where('product_id', $product->id)->first();
            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            }
        } else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as &$cartItem) {
                if ($cartItem['product_id'] == $product->id) {
                    $cartItem['quantity'] = $quantity;
                    break;
                }
            }
            Cart::setCookieCartItems($cartItems);
        }
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            $cartItem = $user->cart()->where('product_id', $product->id)->first();
            if ($cartItem) {
                $cartItem->delete();
                if(CartItem::count() <= 0){
                    return redirect()->route('home')->with('info', 'Cart is empty!');
                }else{
                    return redirect()->back()->with('success', 'Product removed from cart successfully!');
                }
            }
        } else {
            $cartItems = Cart::getCookieCartItems();
            foreach ($cartItems as $key => $cartItem) {
                if ($cartItem['product_id'] == $product->id) {
                    unset($cartItems[$key]);
                    break;
                }
            }
        }
        Cart::setCookieCartItems($cartItems);
        if(count($cartItems) <= 0){
            return redirect()->route('home')->with('info', 'Cart is empty!');
        }else{
            return redirect()->back()->with('success', 'Product removed from cart successfully!');
        }
    }
}
