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
                                <button class="btn btn-sm btn-primary" onclick="showModals()">
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

function setSelectCategory(select, data, param = null) {
    select.empty();

    select.empty();
    if (data.length > 0) {

        select.append(new Option('-- PILIH KATEGORI -- ', ''))

        $.each(data, function (i, v) {
            console.log(v);
            const condited = (param != null && param == v.id) ? true : false
            select.append(new Option(v.type_name.toUpperCase(), v.id, condited, condited));
        });
    }
}

function tableDestroyed(tables) {
    if ($.fn.DataTable.isDataTable('#' + tables)) {
        $('#' + tables).DataTable().destroy();
    }
}

function getClassifications(param = null) {
    Api.get('classifications/all').then(function(response) {
        const {data} = response;
        setSelectCategory(selectClassification, data, param);
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
            render: function(data) {
                return data.toUpperCase();
            }
        },
        {
            data: "name",
            name: "name",
        },
        {
            data: "value",
            name: "value",
            render: function(data, type, row) {
                console.log("Row", row)
                if(row.type_name == 'condition') {
                    return (data == 1) ? 'Ada' : 'Tidak Ada'
                }

                return data;
            }
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

function showModals() {

    $("#componentClassed").children().hide()
    modalName.find('#formClassification').trigger("reset");
    getClassifications()

    modalName.find('.modal-footer button#submitClassification').attr('data-id', "");
    modalName.find('.modal-title').text('Tambah Klassifikasi Produk');
    modalName.find('.modal-footer button#submitClassification').text('save');
    modalName.modal('show');
}

function editRow(id) {
    Api.get(`/classification_products/${id}`).then(function(response) {
        console.log(response);
        const {data} = response;
        modalName.find('#formClassification').trigger("reset");

        getClassifications(data.classification_id)
        $("#componentClassed").children().hide()
        modalName.find('.modal-footer button#submitClassification').attr('data-id', data.id);
        modalName.find('.modal-title').text('Ubah Klassifikasi Produk');
        modalName.find('.modal-footer button#submitClassification').text('Update');
        modalName.modal('show');

        $("#classedName").val(data.name);

        switch (data.classification.type_name.toUpperCase()) {
            case 'NUMERIC':
                $("#classedValueNumeric").show();
                $("#classedValueNumeric").val(data.value)
                break;

            case 'TEXT':
                $("#classedValueText").show();
                $("#classedValueText").val(data.value)
                break;

            case 'LISTED':
                $(".bootstrap-tagsinput").show()
                $('#classedValueListed').tagsinput('add', data.value);
                break;

            default:
                $("#classedValueCondition").show();
                $("#classedValueCondition").val(data.value)
                break;
        }
    });
}

function deleteRow(id) {
    swal({
        title: "Anda Yakin?",
        text: "Data Klassifikasi Produk akan terhapus secara permanen!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            Api.delete(`/classification_products/${id}`).then(function(response) {
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
    //var tagify = new Tagify($("#classedValueListed"))

    selectClassification.change(function (e) {
        e.preventDefault();
        const selected = $('#selectClassification option:selected').text();

        $("#componentClassed").children().hide();

        switch (selected) {
            case 'NUMERIC':
                $("#classedValueNumeric").show();
                break;

            case 'TEXT':
                $("#classedValueText").show();
                break;

            case 'LISTED':
                $(".bootstrap-tagsinput").show()
                break;

            default:
                $("#classedValueCondition").show();
                break;
        }
    });


    $('#submitClassification').click(function (e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        const selected = $('#selectClassification option:selected').text();

        var data = {
            classification_id: $("#selectClassification").val(),
            name: $("#classedName").val(),
            value: '',
        }

        switch (selected) {
            case 'NUMERIC':
                data.value = $("#classedValueNumeric").val();
                break;

            case 'TEXT':
                data.value = $("#classedValueText").val();
                break;

            case 'LISTED':
                data.value = $("#classedValueListed").val();
                break;

            default:
                data.value = $("#classedValueCondition").val();
                break;
        }


        console.log("Data", data);

        if(id == '') {
            /** Create New */
            Api.post('/classification_products', data).then(function(response) {
                const {data, status} = response;
                if(data.success) {
                    swal("Berhasil", data.message, "success");
                    initDatatables(tableStructure);
                    hideCategoryModal()
                }
            }).catch(function(error) {
                console.log("Error", error)
            })

        }
        else {
            Api.put(`/classification_products/${id}`, data).then(function(response) {
                console.log("Response", response);
                const {data, status} = response;
                if(data.success) {
                    swal("Berhasil", data.message, "success");
                    initDatatables(tableStructure);
                    hideCategoryModal()
                }
            }).catch(function(error) {
                console.log("Error", error)
            })
        }

    });

});

</script>
@endpush
