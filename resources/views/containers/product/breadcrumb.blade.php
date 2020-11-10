<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>MASTER {{strtoupper($records['title'])}}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="btn btn-link btn-sm">
                    <strong>Data Produk</strong>
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('classification_products.index') }}" class="btn btn-link btn-sm">
                    <strong>Klasifikasi Produk</strong>
                </a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('details_product.index') }}" class="btn btn-link btn-sm">
                    <strong>Detail Produk</strong>
                </a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
