@extends('layouts.web')

@section('content')

@include('containers.product.breadcrumb', ['records' => $records])

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>FORM UPDATE PRODUK</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-sm-6 m-b-xs">
                            <form>
                                <div class="form-group row">
                                    <label for="selectCategory" class="col-sm-4 col-form-label col-form-label-sm">
                                        Kategori Produk
                                    </label>
                                    <div class="col-sm-8">
                                        <select id="selectCategory" class="form-control"></select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productCode" class="col-sm-4 col-form-label col-form-label-sm">
                                        Barcode/Kode Produk
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text" id="productCode" class="form-control" readonly />
                                    </div>

                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-white" onclick="generateCode()">
                                            <i class="fa fa-barcode"></i> Generate Code
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productName" class="col-sm-4 col-form-label col-form-label-sm">
                                        Nama Produk
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="productName" class="form-control" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productDesc" class="col-sm-4 col-form-label col-form-label-sm">
                                        Keterangan
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea id="productDesc" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-4 col-sm-8">
                                        <button id="submitProduct" type="button" class="btn btn-primary" data-id="">
                                            <i class="fa fa-save"></i>
                                            Update
                                        </button>
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
var selectCategory = $("#selectCategory");
var productCode = $("#productCode");
var productName = $("#productName");
var productDesc = $("#productDesc");
var submitProduct = $("#submitProduct");

function setSelectBox(select, data, param = null) {
    select.empty();

    select.empty();
    if (data.length > 0) {

        select.append(new Option('-- PILIH KATEGORI -- ', ''))

        $.each(data, function (i, v) {
            const bools = (param != null && param == v.id) ? true : false
            select.append(new Option(v.name, v.id, bools, bools));
        });
    }
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function generateCode() {
    var val0 = getRandomInt(1,20);
    var val1 = Math.floor(100000 + Math.random() * 999999);
    var val2 = Math.floor(10000 + Math.random() * 99999);
    productCode.val(val0+' '+val1+' '+val2)
}

function loadForm() {
    const {product, categories} = records;
    setSelectBox(selectCategory, categories, product.category_id)
    productCode.val(product.code);
    productName.val(product.name);
    productDesc.val(product.description);
    submitProduct.attr('data-id', product.id);
}



$(function () {
    console.log(records);
    loadForm()

    submitProduct.click(function (e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        var data = {
            category_id: selectCategory.val(),
            code: productCode.val(),
            name: productName.val(),
            description: productDesc.val()
        }

        if(data.category_id != '') {
            Api.put(`/products/${id}`, data).then(function(response) {
                console.log("Response", response);
                const {data, status} = response;

                if(data.success) {
                    swal("Berhasil", data.message, "success");
                    window.location.href = "{!! url('products') !!}"
                }

            }).catch(function(error) {
                console.log("Errors", error);
            });

        }

    });

});

</script>
@endpush
