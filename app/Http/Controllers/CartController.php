<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductLang;
use App\Models\Order;
use App\Models\Region;
use App\Models\Page;

class CartController extends Controller
{
    public function cart($lang)
    {
        $items = session()->get('items', []);
        
        return view('market.cart', compact('items', 'lang'));
    }

    public function checkout($lang)
    {
        $items = session()->get('items', []);
        
        if (empty($items)) {
            return redirect('/'.$lang.'/market/cart');
        }

        $regions = Region::where('lang', $lang)->get();
        
        return view('market.checkout', compact('items', 'regions', 'lang'));
    }

    public function addToCart(Request $request, $lang, $id)
    {
        $count = (int) $request->input('count', 1);
        $product = Product::findOrFail($id);
        $productLang = ProductLang::where('product_id', $product->id)->where('lang', $lang)->first();

        
        $items = session()->get('items', []);

        if (isset($items[$id])) {
            $items[$id]['count'] += $count;
        } else {
            $items[$id] = [
                'id' => $id,
                'count' => $count,
                'product' => $product,
                'productLang' => $productLang,
                'price' => $product->price
            ];
        }

        session()->put('items', $items);
        
        $countItems = count($items);

        return response()->json([
            'countItems' => $countItems
        ]);
    }

    public function removeFromCart($lang, $id)
    {
        $items = session()->get('items');

        if (isset($items[$id])) {
            if ($items[$id]['count'] > 1) {
                $items[$id]['count']--;
                session()->put('items', $items);
            } else {
                unset($items[$id]);
                session()->put('items', $items);
            }
        }

        return redirect()->back();
    }

    public function destroy($lang, $id)
    {
        $items = session()->get('items');

        if (isset($items[$id])) {
            unset($items[$id]);
            session()->put('items', $items);
        }

        return redirect()->back();
    }

    public function clearCart($lang)
    {
        session()->forget('items');
        return redirect()->back();
    }

    public function storeOrder(Request $request, $lang)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'region_id' => 'required|integer',
            'address' => 'required|max:255',
        ]);

        $items = session()->get('items');
        
        if (empty($items)) {
            return redirect('/'.$lang.'/market')->with('warning', __('Cart is empty'));
        }

        $order = new Order;
        $order->user_id = auth()->check() ? auth()->id() : 0;
        $order->type = 1;
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->region_id = $request->region_id;
        $order->address = $request->address;
        
        $count = 0;
        $amount = 0;
        foreach ($items as $item) {
            $count += $item['count'];
            $amount += ($item['price'] * $item['count']);
        }
        
        $order->count = $count;
        $order->price = $amount;
        $order->amount = $amount;
        $order->delivery = 0;
        $order->payment_type = $request->payment_type ?? 1;
        $order->status = 1;
        
        $order->save();

        foreach ($items as $item) {
            $order->products()->attach($item['id']);
        }

        session()->forget('items');

        return redirect('/'.$lang.'/market')->with('status', 'Заказ успешно оформлен!');
    }
}
