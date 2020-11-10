<div class="modal inmodal" id="modalProductClass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Modal title</h4>
                <small class="font-bold">Form Produk Variant</small>
            </div>
            <div class="modal-body">
                <form id="formProductClass">
                    <div class="form-group row">
                        <label for="selectClassName" class="col-sm-4 col-form-label col-form-label-sm">
                            Nama Klasifikasi
                        </label>
                        <div class="col-sm-8">
                            <select id="selectClassName" class="form-control"></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputValueVariant" class="col-sm-4 col-form-label col-form-label-sm">
                            Nilai Variant
                        </label>
                        <div id="componentVariant" class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="inputValueVariant">

                            <select id="selectedVariant" multiple="multiple"></select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">
                    Close
                </button>
                <button id="saveProductClass" type="button" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
