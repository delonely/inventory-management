<div class="modal fade" id="addkategorimodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Supplier</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;</button>
            </div>
            <form id="formSimpan" class="row g-3 needs-validation" novalidate>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-md-3 col-form-label">Kategori</label>
                        <div class="col-md-9">
                            <select name="kategori" id="kategori" class="select2-selection__rendered" aria-label="parent select" required>
                            </select>
                            <div class="valid-feedback">kategori Terpilih</div>
                            <div class="invalid-feedback">Mohon Pilih Salah Satu Kategori.</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama Supplier</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control " id="nama" name="nama" required>
                            <div class="valid-feedback">Nama Sesuai</div>
                            <div class="invalid-feedback">Mohon Isi Nama .</div>
                        </div>
                        <input type="hidden" name="dataId" id="dataId" value="0" />
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Alamat</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control " id="alamat" name="alamat" min="0" max="100" required>
                            <div class="valid-feedback">Alamat Sesuai</div>
                            <div class="invalid-feedback">Mohon isi Alamat.</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Telepon</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control " id="telp" name="telp" required>
                            <div class="valid-feedback">No Telepon Sesuai</div>
                            <div class="invalid-feedback">Mohon isi No Telepon.</div>
                        </div>
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