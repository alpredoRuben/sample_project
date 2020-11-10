<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

/** Models */
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use App\Models\ProductClassification;

class MasterDatatableController extends Controller
{
    public function categoriesRecord(Request $req)
    {
        $records = Category::orderBy('id', 'desc')->get();
        $user = Auth::user();

        return DataTables::of($records)->addColumn('action', function ($query) use ($user) {
            $str = '';
            if ($user->hasRole('admin')) {
                $str .= '<button type="button" class="btn btn-success btn-sm" onclick="editRow(\'' . $query->id . '\')" title="Edit Row">';
                $str .= '<i class="fa fa-edit"></i>';
                $str .= '</button>&nbsp;';

                $str .= '<button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(\'' . $query->id . '\')" title="Delete Row">';
                $str .= '<i class="fa fa-trash"></i>';
                $str .= '</button>';
            }

            return $str;
        })->rawColumns(['action'])->make(true);
    }

    public function productsRecord(Request $req)
    {
        $user = Auth::user();
        $records = Product::with(['product_details', 'user', 'category'])->orderBy('id', 'desc')->get();

        return DataTables::of($records)->addColumn('action', function ($query) use ($user) {
            $str = '';
            $str .= '<button type="button" class="btn btn-sm btn-primary" onclick="viewRow(\'' . $query->id . '\')" title="Preview Row">';
            $str .= '<i class="fa fa-eye"></i>';
            $str .= '</button>&nbsp;';

            if ($user->hasRole('admin')) {
                $str .= '<button type="button" class="btn btn-success btn-sm" onclick="editRow(\'' . $query->id . '\')" title="Edit Row">';
                $str .= '<i class="fa fa-edit"></i>';
                $str .= '</button>&nbsp;';

                $str .= '<button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(\'' . $query->id . '\')" title="Delete Row">';
                $str .= '<i class="fa fa-trash"></i>';
                $str .= '</button>';
            }

            return $str;
        })->addColumn('status', function ($query) {
            return $query->product_details;
        })->rawColumns(['action'])->make(true);
    }

    public function prodcutClassificationRecord(Request $req)
    {
        $user = Auth::user();
        $records = ProductClassification::with(['classification'])->orderBy('id', 'desc')->get();

        return DataTables::of($records)->addColumn('action', function ($query) use ($user) {

            if ($user->hasRole('admin')) {
                $str .= '<button type="button" class="btn btn-success btn-sm" onclick="editRow(\'' . $query->id . '\')" title="Edit Row">';
                $str .= '<i class="fa fa-edit"></i>';
                $str .= '</button>&nbsp;';

                $str .= '<button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(\'' . $query->id . '\')" title="Delete Row">';
                $str .= '<i class="fa fa-trash"></i>';
                $str .= '</button>';
            }

            return $str;
        })->addColumn('type_name', function ($query) {
            return $query->classification->type_name;
        })->rawColumns(['action'])->make(true);
    }
}
