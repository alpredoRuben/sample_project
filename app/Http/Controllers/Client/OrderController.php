<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductDetail;

class OrderController extends Controller
{
    public function previewOrder($id)
    {
        $details = \App\Models\ProductDetail::with([
            'product',
            'product_variants' => function ($q) {
                $q->with(['product_classification']);
            },
        ])->find($id);

        $records = [
            'user' => Auth::user(),
            'title' => 'produk',
            'subtitle' => 'DETAIL PRODUK',
        ];

        return view('containers.orders.preview_order', compact('records', 'details'));
    }

    public function previewCart()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'cart',
            'subtitle' => 'KERANJANG BELANJA',
        ];

        return view('containers.orders.preview_cart', compact('records'));
    }

    public function addToCart(Request $req)
    {
        $productDetail = ProductDetail::find($req->product_detail_id);
        if (!$productDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 404);
        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if (!$cart) {
            $cart[$productDetail->id] = [
                "total_quantity" => 1,
                "list_order" => []
            ];

            array_push($cart[$productDetail->id]["list_order"], [
                "product_detail_id" => $productDetail->id,
                "code" => uniqid(),
                "name" => $productDetail->name,
                "description" => $req->description,
                "quantity" => $req->quantity,
                "price" => $productDetail->price,
                "total_price" => $req->total_price,
            ]);

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Menambahkan ke keranjang berhasil'
            ], 200);
        }


        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$productDetail->id])) {
            $cart[$productDetail->id]['total_quantity']++;
            array_push($cart[$productDetail->id]["list_order"], [
                "product_detail_id" => $productDetail->id,
                "code" => uniqid(),
                "name" => $productDetail->name,
                "description" => $req->description,
                "quantity" => $req->quantity,
                "price" => $productDetail->price,
                "total_price" => $req->total_price,
            ]);

            session()->put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Menambahkan ke keranjang berhasil'
            ], 200);
        }


        // if item not exist in cart then add to cart with quantity = 1
        $cart[$productDetail->id] = [
            "total_quantity" => 1,
            "list_order" => []
        ];

        array_push($cart[$productDetail->id]["list_order"], [
            "product_detail_id" => $productDetail->id,
            "code" => uniqid(),
            "name" => $productDetail->name,
            "description" => $req->description,
            "quantity" => $req->quantity,
            "price" => $productDetail->price,
            "total_price" => $req->total_price,
        ]);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Menambahkan ke keranjang berhasil'
        ], 200);
    }

    public function removeCart($id, $code)
    {
        $carts = session()->get('cart');

        if ($carts && count($carts) > 0) {
            if (isset($carts[$id])) {
                $lists = $carts[$id];
                if (count($lists['list_order']) > 0) {
                    $filters = [];
                    foreach ($lists['list_order'] as $value) {
                        if ($value['code'] != $code) {
                            array_push($filters, $value);
                        }
                    }

                    if (count($filters) > 0) {
                        $carts[$id]['list_order'] = $filters;
                        $carts[$id]['total_quantity'] = count($filters);
                    } else {
                        unset($carts[$id]);
                    }

                    session()->put('cart', $carts);
                    session()->flash('success', 'Produk pesanan berhasil dihapus');
                } else {
                    session()->flash('error', 'List pesanan kosong');
                }
            } else {
                session()->flash('error', 'Produk pesanan tidak ditemukan');
            }
        } else {
            session()->flash('error', 'Keranjang belanja kosong');
        }
    }

    public function tester()
    {
        //session()->put('cart', []);

        $carts = session()->get('cart');

        if ($carts && count($carts) > 0) {
            $results = [];
            foreach ($carts as $value) {
                array_push($results, $value);
            }

            return $results;
        }

        return $carts;
    }
}
