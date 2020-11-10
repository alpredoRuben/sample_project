<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classification;

class ClassificationController extends Controller
{
    public function getClassifications()
    {
        $classifications = Classification::all();
        return response()->json($classifications);
    }
}
