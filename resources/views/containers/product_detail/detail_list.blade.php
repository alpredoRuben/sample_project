@extends('layouts.web')


@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{strtoupper($records['title'])}}</h2>
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
                    <div class="table-responsive">
                        <table id="tableDetailProducts" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                    <th>Harga Stauan</th>
                                    <th>Group Produk</th>
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
var localTable = "tableDetailProducts";

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
            className: 'align-middle',
            data: "name",
            name: "name",
        },
        {
            className: 'text-center align-middle',
            data: "stock",
            name: "stock",
        },
        {
            className: 'text-right align-middle',
            data: "price",
            name: "price",
        },
        {
            className: 'text-center align-middle',
            data: "group_name",
            name: "group_name",
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

    var _url = BASE_URL + '/datatables/product_details'
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

$(function () {
    initDatatables(localTable);
});

</script>
@endpush
