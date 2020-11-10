@extends('layouts.web')


@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{strtoupper($records['subtitle'])}}</h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Informasi Pesanan Anda</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">

                            <h2 class="font-bold m-b-xs">
                                {{ $details['name'] }}
                            </h2>

                            <small>
                                {{ $details['product']['name']}}
                            </small>

                            <div class="m-t-md">
                                <h2 class="product-main-price">
                                    Rp {{ $details['price'] }}
                                </h2>
                            </div>

                            <h4>Deskripsi Produk</h4>

                            @if (count($details['product_variants']) > 0)
                            <div class="small text-muted">
                                Untuk jenis variant produk ini, Anda dapat melihat komponen varian di bawah ini
                            </div>
                            @endif

                            <dl class="small m-t-md">
                            @foreach ($details['product_variants'] as $item)
                                <dt>
                                    {{ ucfirst($item['product_classification']['name']) }}
                                </dt>
                                <dd>
                                {{
                                    implode(", ", json_decode($item['variant_value'], true))
                                }}
                                </dd>
                            @endforeach
                            </dl>

                            <hr>

                            <div>
                                <div class="btn-group">
                                    <button id="buttonAddCart" class="btn btn-primary btn-sm">
                                        <i class="fa fa-cart-plus"></i>
                                        Tambah Keranjang
                                    </button>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <form action="">
                                <div class="form-group row">
                                    <label for="inputDescription" class="col-sm-4 col-form-label col-form-label-sm">
                                        Keterangan
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea id="inputDescription" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputCountOrder" class="col-sm-4 col-form-label col-form-label-sm">
                                        Jumlah Pesanan
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control form-control-sm" id="inputCountOrder">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="totalOrderProduct" class="col-sm-4 col-form-label col-form-label-sm">
                                        Total Belanja
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control form-control-sm" id="totalOrderProduct" readonly>
                                    </div>
                                </div>


                            </form>
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
var details = {!! json_encode($details, JSON_HEX_TAG) !!}

var inputCountOrder = $("#inputCountOrder");
var inputDescription = $("#inputDescription");
var totalOrderProduct = $("#totalOrderProduct");
var buttonAddCart = $("#buttonAddCart")

$(function () {
    console.log("Records", records);
    console.log("Product Details", details);

    inputCountOrder.keyup(function (e) {
        var text = $(this).val();
        var total = (text == '') ? 0 : details.price * parseInt(text);
        totalOrderProduct.val(total);
    });

    buttonAddCart.click(function (e) {
        e.preventDefault();

        if(inputCountOrder.val() == '') {
            swal("Akses Ditolak", "Silahkan isi jumlah pesanan", "warning");
        }
        else {
            const data = {
                product_detail_id: details.id,
                quantity: inputCountOrder.val(),
                description: inputDescription.val(),
                total_price: totalOrderProduct.val(),
            };

            Api.post('/orders/add_to_cart', data).then(function(response) {
                const {data, status} = response;

                if(data.success) {
                    swal("Berhasil", data.message, "success");
                    window.location.href = "{!! url('list/details_product') !!}"
                }
            });

        }

    });
});

</script>
@endpush
