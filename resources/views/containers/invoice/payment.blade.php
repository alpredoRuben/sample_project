@extends('layouts.web')


@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{strtoupper($records['subtitle'])}}</h2>
    </div>
</div>

<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Informasi Faktur Pembelian</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="form-group row">
                                    <label for="noFaktur" class="col-sm-4 col-form-label col-form-label-sm">
                                        No. Faktur
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="noFaktur" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customerName" class="col-sm-4 col-form-label col-form-label-sm">
                                        Nama Pelanggan
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="customerName" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customerName" class="col-sm-4 col-form-label col-form-label-sm">
                                        Alamat
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea  id="customerAddress" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-4 col-sm-8">
                                        <button type="button" class="btn btn-primary" onclick="submitInvoice()">
                                            Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <h3>Daftar Belanja</h3>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableCustomerOrder" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Keterangan</th>
                                            <th>Qty</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($carts) > 0)
                                        @foreach ($carts as $cart)
                                        <tr>
                                            <td>{{ $cart['index'] }}</td>
                                            <td>{{ $cart['name'] }}</td>
                                            <td>{{ $cart['description'] }}</td>
                                            <td>{{ $cart['quantity'] }}</td>
                                            <td>{{ $cart['price'] }}</td>
                                            <td>{{ $cart['total_price'] }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-right">Total Belanja (Rp.) : </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@push('scripts')
<script type="text/javascript">
var records = {!! json_encode($records, JSON_HEX_TAG) !!}
var carts = {!! json_encode($carts, JSON_HEX_TAG) !!}

function submitInvoice() {
    const data = {
        no_invoice: $("#noFaktur").val(),
        customer_name: $("#customerName").val(),
        customer_address: $("#customerAddress").val()
    }

    if(carts && carts.length > 0) {
        Api.post('/invoices/store/payment', data).then(function(response) {
            console.log("Response", response);
            const {data, status} = response;

            if(data.success) {
                swal("Berhasil", data.message, "success");
                window.location.href = "{!! url('/invoices') !!}"
            }
        });
    }
    else {
        swal('OPPS!', 'List keranjang belanja kosong. Mohon input pesanan terlebih dahulu', 'warning');
    }



}

$(function () {
    console.log("Carts",carts);

    $("#tableCustomerOrder").DataTable({
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $(api.column( 5 ).footer() ).html(pageTotal);

            console.log(pageTotal)
        }
    });
});

</script>
@endpush
