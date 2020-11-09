<div class="modal inmodal" id="modalCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Modal title</h4>
                <small class="font-bold">Form Master Kategori</small>
            </div>
            <div class="modal-body">
                <form id="formCategory">
                    <div class="form-group row">
                        <label for="categoryName" class="col-sm-4 col-form-label col-form-label-sm">
                            Nama Kategori
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="categoryName">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="categoryDesc" class="col-sm-4 col-form-label col-form-label-sm">
                            Keterangan
                        </label>
                        <div class="col-sm-8">
                            <textarea id="categoryDesc" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">
                    Close
                </button>
                <button id="submitCategory" type="button" class="btn btn-primary" data-id="">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
