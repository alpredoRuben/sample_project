@extends('layouts.web')


@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{strtoupper($records['subtitle'])}}</h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ $message }}</strong>
      </div>
    @endif

    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
      </div>
    @endif


    @if (session('cart'))
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Informasi Belanja Anda</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">


                    <div class="table-responsive">
                        <table class="table shoping-cart-table">
                            <tbody>
                            @foreach (session('cart') as $cart)

                                @foreach ($cart['list_order'] as $item)
                                    <tr>
                                        <td width="90">
                                            <div class="cart-product-imitation">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </td>
                                        <td class="desc">
                                            <h3>
                                                <a href="#" class="text-navy">
                                                    {{ strtoupper($item['name']) }}
                                                </a>
                                            </h3>

                                            <p>
                                                {{ $item['description'] }}
                                            </p>

                                            <div class="m-t-sm">

                                                <button class="btn btn-sm btn-danger" onclick="removeItem({{$item["product_detail_id"]}}, '{{$item["code"]}}' )">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            Rp. {{ $item['price'] }} <br/>
                                            <small>Harga Satuan</small>
                                        </td>
                                        <td width="65">
                                            <input type="text" class="form-control" readonly placeholder="{{ $item['quantity'] }}">
                                        </td>
                                        <td>
                                            <h4 class="text-left align-middle text-primary">{{ $item['total_price'] }}</h4>
                                        </td>
                                    </tr>
                                @endforeach

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="ibox-content">
                    <a href="{{ url('invoices/view/payment') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-shopping-cart"></i>
                        Lanjutkan Bayar
                    </a>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Cart Summary</h5>
                </div>
                <div class="ibox-content">
                    <span>
                        Total
                    </span>
                    <h2 class="font-bold">
                        @php
                            $carts = session('cart');

                            if($carts) {
                                $sumOrder = 0;
                                foreach ($carts as $cart) {
                                    foreach ($cart['list_order'] as $item) {
                                        $sumOrder += (double) $item['total_price'];
                                    }
                                }

                                echo 'Rp. '.$sumOrder;
                            }
                            else {
                                echo 'Rp. 0';
                            }
                        @endphp
                    </h2>

                    <hr />

                    <div class="m-t-sm">
                        <div class="btn-group">
                            <a href="{{ url('invoices/view/payment') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-shopping-cart"></i>
                                Lanjutkan Bayar
                            </a>
                            &nbsp;
                            <a href="#" class="btn btn-danger btn-sm">
                                <i class="fa fa-times"></i>
                                Batal
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else

    <div class="row">
        <div class="col-md-12">
            <h3>
                Keranjang Belanja Kosong
            </h3>
        </div>
    </div>

    @endif




</div>

@endsection


@push('scripts')
<script type="text/javascript">
var records = {!! json_encode($records, JSON_HEX_TAG) !!}

function removeItem(id, code) {
    console.log(id, code);

    Api.get('/orders/remove/'+id+'/cart/'+code).then(function(response) {
        window.location.reload();
    });
}


$(function () {

});

</script>
@endpush
