<div class="modal fade" id="addunitmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Data Unit</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;
                </button>
            </div>
            <form id="formSimpan" class="row g-3 needs-validation" novalidate>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nama Unit</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="nama" id="nama" required>
                            <div class="valid-feedback">Nama Unit Terisi</div>
                            <div class="invalid-feedback">Mohon Isi Nama Unit.</div>
                        </div>
                        <input type="hidden" name="dataId" id="dataId" value="0" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit me-2" id="pensubmit" onclick="simpan()">Simpan</button>
                    <button type="button" class="btn btn-cancel" onclick="batal()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal-->