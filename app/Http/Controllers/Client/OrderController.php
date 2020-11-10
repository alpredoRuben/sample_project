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
            $cart = [
                $productDetail->id => [
                    "name" => $productDetail->name,
                    "description" => $req->description,
                    "quantity" => $req->quantity,
                    "price" => $req->price,
                    "total_price" => $req->total_price
                ]
            ];

            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Menambahkan ke keranjang berhasil'
            ], 200);
        }


        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$productDetail->id])) {
            $cart[$productDetail->id]['quantity']++;
            session()->put('cart', $cart);
            return response()->json([
                'success' => true,
                'message' => 'Menambahkan ke keranjang berhasil'
            ], 200);
        }


        // if item not exist in cart then add to cart with quantity = 1
        $cart[$productDetail->id] = [
            "name" => $productDetail->name,
            "description" => $req->description,
            "quantity" => $req->quantity,
            "price" => $req->price,
            "total_price" => $req->total_price
        ];
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Menambahkan ke keranjang berhasil'
        ], 200);
    }
}
