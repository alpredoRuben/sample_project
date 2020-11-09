<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'dashboard'
        ];

        return view('containers.dashboard.index', compact('records'));
    }
}
