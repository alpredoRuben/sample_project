<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Invoice;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function viewInvoice()
    {
        $invoices = Invoice::with(['user'])->orderBy('id', 'DESC')->get();
        $records = [
            'user' => Auth::user(),
            'title' => 'data faktur',
        ];

        return view('containers.invoice.index', compact('records', 'invoices'));
    }

    public function generateCart()
    {
        $carts =  session()->get('cart');

        if ($carts) {
            $results = [];
            $index = 1;
            foreach ($carts as $cart) {
                foreach ($cart['list_order'] as $item) {
                    $item["index"] = $index;
                    array_push($results, $item);
                    $index++;
                }
            }

            return $results;
        }

        return [];
    }

    public function viewPayment()
    {
        $carts =  $this->generateCart();

        if ($carts && count($carts) > 0) {
            $records = [
                'user' => Auth::user(),
                'title' => 'invoice',
                'subtitle' => 'Faktur Pembelian'
            ];

            return view('containers.invoice.payment', compact('records', 'carts'));
        } else {
            return abort(404);
        }
    }


    public function storePayment(Request $req)
    {
        $this->validate($req, [
            'no_invoice' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required'
        ]);

        $invoice = Invoice::where('invoice_code', $req->no_invoice)->first();

        if ($invoice) {
            return response()->json([
                'success' => false,
                'message' => 'No Faktur '.$req->no_invoice.' sudah pernah ada'
            ], 400);
        }

        $invoice = Invoice::create([
            'invoice_code' => $req->no_invoice,
            'customer_name' => $req->customer_name,
            'customer_address' => $req->customer_address,
            'invoice_type' => 'payment',
            'user_id' => Auth::user()->id
        ]);

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Faktur pembayaran gagal disimpan'
            ], 400);
        }

        $carts = $this->generateCart();

        if (count($carts) > 0) {
            $results = [];

            foreach ($carts as $cart) {
                $order = Order::create([
                    'product_detail_id' => $cart['product_detail_id'],
                    'code' => $cart['code'],
                    'name' => $cart['name'],
                    'description' => $cart['description'],
                    'quantity' => $cart['quantity'],
                    'price' => $cart['price'],
                    'total_price' => $cart['total_price'],
                    'invoice_id' => $invoice->id,
                ]);

                if ($order) {
                    array_push($results, $order);
                }
            }

            if (count($carts) == count($results)) {
                session()->put('cart', []);
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil disimpan'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Data pesanan gagal disimpan'
            ], 400);
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki daftar pesanan'
        ], 400);
    }
}
