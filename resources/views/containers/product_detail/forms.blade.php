@extends('layouts.web')


@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('details_product.index') }}" class="btn btn-link btn-sm">
                    <i class="fa fa-chevron-left"></i> Kembali Ke Detail Produk
                </a>
            </li>

        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>{{ strtoupper($records['subtitle']) }}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <form id="formClassification">
                        <div class="row">

                            <div class="col-sm-6 m-b-xs">
                                <div class="form-group row">
                                    <label for="productGroup" class="col-sm-4 col-form-label col-form-label-sm">
                                        Grup Produk
                                    </label>
                                    <div class="col-sm-8">
                                        <select id="productGroup" class="form-control"></select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productDetailName" class="col-sm-4 col-form-label col-form-label-sm">
                                        Nama Detail
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="productDetailName">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productDetailStock" class="col-sm-4 col-form-label col-form-label-sm">
                                        Stok Produk
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control form-control-sm" id="productDetailStock">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productDetailPrice" class="col-sm-4 col-form-label col-form-label-sm">
                                        Harga Satuan
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="productDetailPrice">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="productGroup" class="col-sm-4 col-form-label col-form-label-sm">
                                        Tambah Variant
                                    </label>
                                    <div class="col-sm-8">
                                        <button type="button" class="btn btn-white" onclick="showModals()">
                                            <i class="fa fa-plus"></i> Variant
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="row">
                        <div class="clearfix">&nbsp</div>
                    </div>

                    <h3>Produk Variant</h3>
                    <div class="table-responsive">
                        <table id="tableVariant" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tipe</th>
                                    <th>Nama Variant</th>
                                    <th>Nilai Variant</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="clearfix">&nbsp;</div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <button id="saveAll" type="button" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>

@include('containers.product_detail.modals');

@endsection


@push('scripts')
<script type="text/javascript">
var records = {!! json_encode($records, JSON_HEX_TAG) !!};
var productGroup = $("#productGroup");
var selectClassName = $("#selectClassName");
var modalName = $("#modalProductClass");
var storageName = 'STORAGE_VARIANT';
var localTable = "tableVariant"


/** Datatablse Column */
function getColumns() {
    return [
        {
            className: 'text-center',
            defaultContent: '',
        },
        {
            data: "classificaton_name",
            render: function(data) {
                return data.toUpperCase()
            }
        },
        {
            data: "product_class_name",
        },
        {
            data: "variant_value",
        },
        {
            className: "text-center",
            render: function(data, type, row) {
                var str = '';
                str += '<button type="button" class="btn btn-xs btn-danger" onclick="deleteRow(\'' + row.product_class_id + '\')"><i class="fa fa-trash"></button>';
                return str;
            }
        },
    ]
}

function tableDestroyed(tables) {
    if ($.fn.DataTable.isDataTable('#' + tables)) {
        $('#' + tables).DataTable().destroy();
    }
}

function initDatatables(_table_id) {
    tableDestroyed(_table_id)

    const storage = JSON.parse(localStorage.getItem(storageName));
    var dTables = null

    if(storage) {
        if(storage.length > 0) {

            dTables = $('#' + _table_id).DataTable({
                "AutoWidth": false,
                "data": storage,
                "columnDefs": [
                    {
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    },
                ],
                "columns": getColumns()
            })

            dTables.on( 'order.dt search.dt', function () {
                dTables.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();

        }
        else {
            dTables = $('#' + _table_id).DataTable( {
                "data": storage,
                "language": {
                    "emptyTable": "Record Data Kosong",
                }
            });
        }
    }
    else {
        dTables = $('#' + _table_id).DataTable( {
            "language": {
                "emptyTable": "Record Data Kosong",
            }
        });
    }

}

function setSelectGroup(select, data, param = null) {
    select.empty();

    select.empty();
    if (data.length > 0) {

        select.append(new Option('-- GRUP PRODUK -- ', ''))

        $.each(data, function (i, v) {
            const condited = (param != null && param == v.id) ? true : false
            select.append(new Option(v.name.toUpperCase(), v.id, condited, condited));
        });
    }
}

function setSelectClassification(select, data, param = null) {
    select.empty();

    select.empty();
    if (data.length > 0) {

        select.append(new Option('-- KLASIFIKASI PRODUK -- ', ''))

        $.each(data, function (i, v) {
            const condited = (param != null && param == v.id) ? true : false
            select.append(new Option(v.name.toUpperCase(), v.id, condited, condited));
        });
    }
}

function setSelectedVariant(select, data, param) {
    select.empty();

    select.empty();
    if (data.length > 0) {

        $.each(data, function (index, value) {
            const condited = (param != null && param == value) ? true : false
            select.append(new Option(value, value, condited, condited));
        });
    }
}

function hideCategoryModal() {
    modalName.modal('hide');
}

function showModals() {

    modalName.find('#formProductClass').trigger("reset");

    $("#componentVariant").children().hide();
    modalName.find('.modal-title').text('Tambah Produk Variant');
    modalName.find('.modal-footer button#saveProductClass').text('save');

    setSelectClassification(selectClassName, records.product_classification);
    modalName.modal('show');
}

function deleteRow(id) {

    swal({
        title: "Anda Yakin?",
        text: "Data Produk Variant akan terhapus secara permanen!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {

            const storage = JSON.parse(localStorage.getItem(storageName));

            if(storage) {

                if(storage.length > 0) {

                    const filters = storage.filter(x => x.product_class_id != id);
                    console.log("Filters" ,filters);
                    localStorage.setItem(storageName, JSON.stringify(filters));
                }

            }
            else {
                swal({
                    title: "GAGAL",
                    text: "Hapus data produk variant gagal",
                    icon: "warning",
                });
            }
        }

        initDatatables(localTable);
    });


}


$(function () {
    console.log("Records" , records);

    initDatatables(localTable);

    setSelectGroup(productGroup, records.group_product);

    selectClassName.change(function (e) {
        e.preventDefault();
        $("#componentVariant").children().hide();
        var id = $(this).val();
        const pc = records.product_classification.find(x => x.id == id, {});


        switch (pc.classification.type_name) {
            case 'listed':
                const splitValue = pc.value.split(',');
                console.log("Split Value", splitValue)
                if(splitValue.length > 0) {
                    setSelectedVariant($("#selectedVariant"), splitValue);

                    // $('#selectedVariant option:selected').each(function() {
                    //     $(this).prop('selected', false);
                    // })
                    // $('#selectedVariant').multiselect();
                    $('#selectedVariant').multiselect('destroy');
                    $(".multiselect-native-select").show();
                    $('#selectedVariant').multiselect();


                }
                else {
                    $("#inputValueVariant").val(pc.value);
                    $("#inputValueVariant").show();
                }

                break;

            case 'condition':
                const conditionValue = pc.value == 1 ? "Ada" : "Tidak Ada"
                $("#inputValueVariant").val(conditionValue);
                $("#inputValueVariant").show();
                break;

            default:
                $("#inputValueVariant").val(pc.value);
                $("#inputValueVariant").show();
                break;
        }

    });

    $("#saveProductClass").click(function (e) {
        e.preventDefault();
        const class_id = $("#selectClassName").val();

        const filter = records.product_classification.find(
            x => x.id == class_id
        ,{});

        if(filter) {
            var data = {
                classification_id: filter.classification.id,
                classificaton_name: filter.classification.type_name,
                product_class_id: class_id,
                product_class_name: filter.name,
                product_class_value: filter.value,
                variant_value: '',
            };


            switch (filter.classification.type_name) {
                case 'listed':
                    const splitValue = filter.value.split(',');

                    if(splitValue.length > 0) {
                        data.variant_value = $("#selectedVariant").val();
                    }
                    else {
                        data.variant_value = $("#inputValueVariant").val();
                    }
                    break;

                case 'condition':
                    data.variant_id = filter.value;
                    break;

                default:
                    data.variant_value = $("#inputValueVariant").val();
                    break;
            }

            var storage = JSON.parse(localStorage.getItem(storageName));

            if(storage && storage.length > 0) {
                storage.push(data);
            }
            else {
                storage = [];
                storage.push(data);
            }

            localStorage.setItem(storageName, JSON.stringify(storage));

            swal("Berhasil", "Data variant berhasil ditambahkan", "success");
            initDatatables(localTable);
            hideCategoryModal()
        }
    });


    $("#saveAll").click(function (e) {
        e.preventDefault();
        const storage = JSON.parse(localStorage.getItem(storageName));
        const data = {
            product_id: $("#productGroup").val(),
            name: $("#productDetailName").val(),
            stock: $("#productDetailStock").val(),
            price: $("#productDetailPrice").val(),
            variants: storage
        }

        console.log("Data", data);


    });

});


</script>
@endpush
