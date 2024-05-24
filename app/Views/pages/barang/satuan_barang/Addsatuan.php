<div class="modal fade" id="addsatuanmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Satuan Barang</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;
                </button>
            </div>
            <form id="formSimpan" class="row g-3 need-validation" novalidate>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama Satuan</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <div class="valid-feedback">Nama Satuan Sesuai</div>
                            <div class="invalid-feedback">Mohon Isi Nama Satuan.</div>
                            </div>
                            <input type="hidden" name="dataId" id="dataId" value="0"/>
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