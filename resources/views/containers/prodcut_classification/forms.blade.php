<div class="modal inmodal" id="modalProductClassification" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Modal title</h4>
                <small class="font-bold">Form Klasifikasi Produk</small>
            </div>
            <div class="modal-body">
                <form id="formClassification">
                    <div class="form-group row">
                        <label for="selectClassification" class="col-sm-4 col-form-label col-form-label-sm">
                            Type Data
                        </label>
                        <div class="col-sm-8">
                            <select id="selectClassification" class="form-control"></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="classedName" class="col-sm-4 col-form-label col-form-label-sm">
                            Nama Klasifikasi
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="classedName">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="classedValue" class="col-sm-4 col-form-label col-form-label-sm">
                            Nilai Data
                        </label>
                        <div id="componentClassed" class="col-sm-8">
                            <input type="text" id="classedValueText" class="form-control">
                            <input type="text" data-role="tagsinput" value="" id="classedValueListed">
                            {{-- <input type="text" id="classedValueListed" data-role="tagsinput" value=""> --}}
                            <input type="number" name="classedValueNumeric" id="classedValueNumeric" class="form-control">
                            <select id="classedValueCondition" class="form-control">
                                <option value="1">Ada</option>
                                <option value="0">Tidak Ada</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">
                    Close
                </button>
                <button id="submitClassification" type="button" class="btn btn-primary" data-id="">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
