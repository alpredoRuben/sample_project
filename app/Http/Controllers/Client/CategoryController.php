<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    public function allCategory()
    {
        $records = Category::all();
        return response()->json($records);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'kategori'
        ];


        return view('containers.category.index', compact('records'));
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
            'name'                 => 'required|string',
        ]);

        try {
            $record = Category::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori gagal ditambahkan'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan'
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
        $record = Category::find($id);
        if (!$record) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan'
            ], 400);
        }

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
            'name' => 'required|string',
        ]);

        $record = Category::find($id);
        $record->name = $request->name;
        $record->description = $request->description;
        $record->save();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal diperbarui'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui'
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
            $record = Category::find($id);
            $name = $record->name;
            $record->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori '.$name.' berhasil di hapus'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex
            ]);
        }
    }
}
