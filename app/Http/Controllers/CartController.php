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

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $productLang = $product->productsLang->firstWhere('lang', app()->getLocale());

        if ($request->session()->has('items')) {

            $items = $request->session()->get('items');

            $quantity = (isset($request->quantity)) ? $request->quantity : 1;

            $items['products_id'][$id] = [
                'id' => $id, 'quantity' => $quantity, 'slug' => $productLang->slug, 'title' => $productLang->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
            ];

            if ($items['products_id'][$id]['quantity'] > $product->count) {
                return response()->json(['status' => 'wrong']);
            }

            $request->session()->put('items', $items);
            $count = count($items['products_id']);
            $sum_price_items = 0;

            foreach ($items['products_id'] as $item) {
                $sum_price_item = $item['price'] * $item['quantity'];
                $sum_price_items += $sum_price_item;
            }

            return response()->json([
                'alert' => 'success', 'countItems' => $count, 'sumPriceItems' => $sum_price_items, 'quantity' => $request->quantity, 'slug' => $productLang->slug, 'title' => $productLang->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
            ]);
        }

        $items = [];
        $items['products_id'][$id] = [
            'id' => $id, 'quantity' => 1, 'slug' => $productLang->slug, 'title' => $productLang->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
        ];

        if ($items['products_id'][$id]['quantity'] > $product->count) {
            return response()->json(['status' => 'wrong']);
        }

        $request->session()->put('items', $items);

        return response()->json([
            'alert' => 'success', 'countItems' => 1, 'slug' => $productLang->slug, 'title' => $productLang->title, 'img_path' => $product->path.'/'.$product->image, 'price' => $product->price,
        ]);
    }

    public function addToCart2(Request $request, $lang, $id)
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
