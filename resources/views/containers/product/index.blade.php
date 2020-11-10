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
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-9 m-b-xs">
                            <a href="{{ url('/products/create') }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i>
                                Produk
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableProduk" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Code </th>
                                    <th>Nama Produk</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
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

@endsection


@push('scripts')
<script type="text/javascript">
var tableStructure = 'tableProduk';

function tableDestroyed(tables) {
    if ($.fn.DataTable.isDataTable('#' + tables)) {
        $('#' + tables).DataTable().destroy();
    }
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
            data: "code",
            name: "code",
        },
        {
            data: "name",
            name: "name",
        },
        {
            data: "description",
            name: "description",
        },
        {
            data: "status",
            name: "status",
            render: function(data) {
                if(data.length > 0) {
                    return '<div class="label label-info p-2 text-center">TERSEDIA</div>'
                }
                return '<div class="label label-secondary p-2 text-center">KOSONG</div>'
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

    var _url = BASE_URL + '/datatables/products'
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
    $("#modalCategory").modal('hide');
}

function editRow(id) {
    window.location.href = "{!! url('products/edit') !!}" + "/" + id
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
            Api.delete(`/products/${id}`).then(function(response) {
                const {data, status} = response;
                if(data.success) {
                    swal(data.message, { icon: "success" });
                    initDatatables(tableStructure);
                }
            });
        }


    });
}

$(function () {
    initDatatables(tableStructure);


    $('#submitCategory').click(function (e) {
        e.preventDefault();

        var id = $(this).attr('data-id');

        var data = {
            name: $('#categoryName').val(),
            description: $('#categoryDesc').val()
        }

        if(id == '') {
            /** Create new */
            Api.post('/categories', data).then(function(response) {
                const {data, status} = response;

                if(data.success) {
                    swal("Berhasil", data.message, "success");
                    initDatatables(tableStructure);
                    hideCategoryModal()
                }

            }).catch(function(err) {
                console.log("Error",error)
            })
        }
        else {
            /** Update */
            Api.put(`/categories/${id}`, data).then(function(response) {
                console.log("Response", response);
                const {data, status} = response;

                if(data.success) {
                    swal("Berhasil", data.message, "success");
                    initDatatables(tableStructure);
                    hideCategoryModal()
                }
            }).catch(function(error) {
                console.log("Error", error);
            })
        }

    });
});

</script>
@endpush
