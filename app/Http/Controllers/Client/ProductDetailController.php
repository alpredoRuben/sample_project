<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductDetail;
use App\Models\Product;
use App\Models\Classification;
use App\Models\ProductClassification;
use App\Models\ProductVariant;

class ProductDetailController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'produk'
        ];

        return view('containers.product_detail.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'produk',
            'subtitle' => 'Form Detail Produk',
            'subid' => '',
            'group_product' => Product::get(),
            'classifications' => Classification::get(),
            'product_classification' => ProductClassification::with(['classification'])->get()
        ];

        return view('containers.product_detail.forms', compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        /** Create Product Detail */
        $productDetail = ProductDetail::create([
            'product_id' => $req->product_id,
            'name' => $req->name,
            'stock' => $req->stock,
            'price' => $req->price,
            'user_id' => Auth::user()->id
        ]);

        if (!$productDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Product detail gagal ditambahkan'
            ]);
        }

        $variants = $req->variants;

        if (count($variants) > 0) {
            $enumVariant = [];
            foreach ($variants as $item) {
                $variant_value = '';
                if (is_array($item['variant_value'])) {
                    $variant_value = json_encode($item['variant_value'], true);
                } else {
                    $variant_value = $item['variant_value'];
                }

                $productVariant = ProductVariant::create([
                    'product_detail_id' => $productDetail->id,
                    'product_class_id' => $item['product_class_id'],
                    'variant_value' => $variant_value
                ]);

                array_push($enumVariant, $productVariant);
            }


            if (count($variants) > count($enumVariant)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product variant gagal ditambahkan'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product detail dan variant berhasil ditambahkan'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product detail berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getListDetail()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'produk'
        ];

        return view('containers.product_detail.detail_list', compact('records'));
    }
}
