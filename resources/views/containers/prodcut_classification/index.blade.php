@extends('layouts.web')


@section('content')

@include('containers.product.breadcrumb', ['records' => $records])

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>{{ strtoupper($records['title']) }}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-9 m-b-xs">
                            <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                <button class="btn btn-sm btn-primary" onclick="showModals('add')">
                                    <i class="fa fa-plus"></i>
                                    Klasifikasi Produk
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableClassification" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Tipe</th>
                                    <th>Nama</th>
                                    <th>Nilai (Isi)</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>


</div>

@include('containers.prodcut_classification.forms');

@endsection


@push('scripts')
<script type="text/javascript">
var tableStructure = 'tableClassification';
var modalName = $("#modalProductClassification");
var selectClassification = $("#selectClassification");

function setSelectCategory(select, data, param = null, index = null) {
    select.empty();

    select.empty();
    if (data.length > 0) {

        select.append(new Option('-- PILIH KATEGORI -- ', ''))

        $.each(data, function (i, v) {
            select.append(new Option(
                v.type_name.toUpperCase(),
                v.id,
                (param != null && param == i) ? true : false,
                (param != null && param == i) ? true : false
            ));
        });
    }
}

function tableDestroyed(tables) {
    if ($.fn.DataTable.isDataTable('#' + tables)) {
        $('#' + tables).DataTable().destroy();
    }
}

async function getClassifications(param = null, index = null) {
    await Api.get('classifications/all').then(function(response) {
        console.log(response);
        const {data} = response;
        setSelectCategory(selectClassification, data);
    })
}

function initColumns() {
    return [
        {
            className: 'text-center align-middle',
            defaultContent: '',
        },
        {
            data: "id",
            name: "id",
        },
        {
            data: "type_name",
            name: "type_name",
        },
        {
            data: "name",
            name: "name",
        },
        {
            data: "value",
            name: "value",
        },
        {
            data: "action",
            name: "action",
            className: "text-center align-middle"
        }
    ];
}

function initDatatables(_table_id) {
    tableDestroyed(_table_id)

    var _url = BASE_URL + '/datatables/classification_products'
    var d_tables = $("#" + _table_id).DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        autoWidth: false,
        ordering: true,
        lengthChange: true,
        ajax: {
            url: _url,
        },
        "columnDefs": [
            {
                "targets": [1],
                "visible": false,
                "searchable": false
            },
        ],
        columns: initColumns(),
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        order: [[1, 'desc']]
    });

    d_tables.on('draw.dt', function () {
        d_tables.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = `<div class="text-center"><b>${i + 1}</b></div>`;
        });
    });

    d_tables.on('xhr', function (e, settings, json) {
        console.log(json);
        console.log(settings);
    });

}

function hideCategoryModal() {
    modalName.modal('hide');
}

function showModals(str, data=null) {
    modalName.modal('show');

    var title = 'Tambah Klassifikasi Produk';
    var buttonText = 'Save';

    modalName.find('#formClassification').trigger("reset");
    modalName.find('.modal-footer button#submitClassification').attr('data-id', "");

    $("#componentClassed").children().hide()

    getClassifications()

    if(str != 'add') {
        title = 'Ubah Klassifikasi Produk';
        buttonText = 'Update';
    }

    modalName.find('.modal-title').text(title);
    modalName.find('.modal-footer button#submitClassification').text(buttonText);
}

function editRow(id) {
    Api.get(`/categories/${id}`).then(function(response) {
        const {data} = response;
        showModals('update', data);
        $('#submitCategory').attr('data-id', data.id);
        $("#categoryName").val(data.name);
        $("#categoryDesc").val(data.description);
    });
}

function deleteRow(id) {
    swal({
        title: "Anda Yakin?",
        text: "Data kategori akan terhapus secara permanen!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            Api.delete(`/categories/${id}`).then(function(response) {
                const {data, status} = response;
                if(status == 200) {
                    swal(data.message, { icon: "success" });
                }

                initDatatables(tableStructure);
            });

        }
    });
}

$(function () {
    initDatatables(tableStructure);

    selectClassification.change(function (e) {
        e.preventDefault();
        const selected = $('#selectClassification option:selected').text();

        $("#componentClassed").children().hide();

        switch (selected) {
            case 'NUMERIC':
                $("#classedValueNumeric").show()
                break;

            case 'TEXT':
                $("#classedValueText").show()
                break;

            case 'LISTED':
                $("#classedValueListed").show()
                break;

            default:
                $("#classedValueCondition").show();
                break;
        }


    });

});

</script>
@endpush
