<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'produk'
        ];

        return view('containers.product.index', compact('records'));
    }

    public function create()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'produk'
        ];

        $categories = \App\Models\Category::all();

        return view('containers.product.create', compact('records', 'categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'category_id' => 'required',
        ]);

        try {
            $record = Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
            ]);

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk gagal ditambahkan'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex
            ]);
        }
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
