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
                            <a href="{{ route('details_product.create') }}" class="btn btn-sm btn-primary" >
                                <i class="fa fa-plus"></i>
                                Detail Produk
                            </a>
                        </div>
                    </div>
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
</script>
@endpush
