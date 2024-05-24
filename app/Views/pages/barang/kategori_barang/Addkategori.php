<div class="modal fade" id="addkategorimodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Kategori Barang</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;</button>
            </div>
            <form id="formSimpan" class="row g-3 needs-validation" novalidate>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama Kategori</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control " id="nama" name="nama" required>
                            <div class="valid-feedback">Nama Kategori Sesuai</div>
                            <div class="invalid-feedback">Mohon Isi Nama Kategori.</div>
                        </div>
                        <input type="hidden" name="dataId" id="dataId" value="0"/>
                    </div>
                    <div class="form-group row ">
                        <label class="col-md-3 col-form-label">Parent</label>
                        <div class="col-md-6">
                        <select name="parent" id="parent" class="select2-selection__rendered" aria-label="parent select" required>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Mohon Pilih Salah Satu Parent.</div>
                        </div>
                        <div class="col-lg-3">
                            <label class="col-form-label"><input type="checkbox" id="check" name="check"  class="form-check-input" /> Parent ?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit me-2" id="pensubmit" onclick="simpan()">Simpan</button>
                    <button type="button" class="btn btn-cancel" onclick="batal()" >Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal-->
 