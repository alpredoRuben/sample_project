@extends('layouts.web')


@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{strtoupper($records['title'])}}</h2>
    </div>
</div>

<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Informasi Data Faktur</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableInvoices" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Faktur</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Tipe Faktur</th>
                                            @if ($records['user']->hasRole('admin'))
                                            <th>Dibuat Oleh</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if ($invoices && count($invoices) > 0)
                                        @foreach ($invoices as $item)
                                            <tr>
                                                <td>{{ ($loop->index + 1) }}</td>
                                                <td>{{ $item->invoice_code }}</td>
                                                <td>{{ $item->customer_name }}</td>
                                                <td>{{ $item->customer_address }}</td>
                                                <td>{{ $item->invoice_type == 'payment' ? 'Faktur Penjualan': 'Faktur Pembelian' }}</td>
                                                @if ($records['user']->hasRole('admin'))
                                                <td>{{ $item->user->name }}</th>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
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


$(function () {
    $("#tableInvoices").DataTable();
});

</script>
@endpush
