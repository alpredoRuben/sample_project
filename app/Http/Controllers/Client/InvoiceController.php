<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function viewPayment()
    {
        $records = [
            'user' => Auth::user(),
            'title' => 'invoice',
            'subtitle' => 'Faktur Pembelian',
        ];

        return view('containers.invoice.payment', compact('records'));
    }
}
