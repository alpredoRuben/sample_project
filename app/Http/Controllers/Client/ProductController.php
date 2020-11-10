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
        $record = Product::find($id);
        return response()->json($record, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'category_id' => 'required',
        ]);

        try {
            $record = Product::find($id);

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ]);
            }

            $record->code = $request->code;
            $record->name =$request->name;
            $record->description = $request->description;
            $record->category_id = $request->category_id;
            $record->user_id = Auth::user()->id;
            $record->save();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk gagal diperbarui'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex
            ]);
        }
    }

    public function destroy($id)
    {
    }

    public function lists()
    {
        $records = Product::all();
        return response()->json($records);
    }
}
