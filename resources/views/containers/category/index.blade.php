@extends('layouts.web')


@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>MASTER {{strtoupper($records['title'])}}</h2>
    </div>
</div>

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
                            <div data-toggle="buttons" class="btn-group btn-group-toggle">
                                <button class="btn btn-sm btn-primary" onclick="showModals('add')">
                                    <i class="fa fa-plus"></i>
                                    Kategori
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableCategory" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama </th>
                                    <th>Keterangan </th>
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

@include('containers.category.forms');

@endsection


@push('scripts')
<script type="text/javascript">

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
            data: "name",
            name: "name",
        },
        {
            data: "description",
            name: "description",
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

    var _url = BASE_URL + '/datatables/categories'
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

function showModals(str, data=null) {
    $("#modalCategory").modal('show');

    var modal = $("#modalCategory");
    var title = 'Tambah Kategori';
    var buttonText = 'Save';

    modal.find('#formCategory').trigger("reset");
    modal.find('.modal-footer button#submitCategory').attr('data-id', "");

    if(str != 'add') {
        title = 'Ubah Kategori';
        buttonText = 'Update';
    }

    modal.find('.modal-title').text(title);
    modal.find('.modal-footer button#submitCategory').text(buttonText);
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

                initDatatables('tableCategory');
            });

        }
    });
}

$(function () {
    initDatatables('tableCategory');


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
                    initDatatables('tableCategory');
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
                    initDatatables('tableCategory');
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
