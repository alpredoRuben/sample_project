<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductClassification;

class ProductClassificationController extends Controller
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

        return view('containers.classification.index', compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'classification_id' => 'required',
            'name' => 'required',
            'value' => 'required'
        ]);

        try {
            $record = ProductClassification::create([
                'classification_id' => $request->classification_id,
                'name' => $request->name,
                'value' => $request->value
            ]);

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Klasifikasi Produk gagal ditambahkan'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Klasifikasi Produk berhasil ditambahkan'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = ProductClassification::find($id);
        return response()->json($record, 200);
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
        $this->validate($request, [
            'classification_id' => 'required',
            'name' => 'required',
            'value' => 'required'
        ]);

        $record = ProductClassification::find($id);
        $record->classification_id = $request->classification_id;
        $record->name = $request->name;
        $record->value = $request->value;
        $record->save();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Klasifikasi Produk gagal diperbarui'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Klasifikasi Produk berhasil diperbarui'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $record = ProductClassification::find($id);
            $name = $record->name;
            $record->delete();

            return response()->json([
                'success' => true,
                'message' => 'Klasifikasi Produk '.$name.' berhasil di hapus'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex
            ]);
        }
    }
}
