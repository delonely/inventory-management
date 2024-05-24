<div class="modal fade" id="editsatuanmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Edit Satuan Barang</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;
                </button>
            </div>
            
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Id Satuan</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" value="<?=$data->idSatuan?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Nama Satuan</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control"  value="<?=$data->nama?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Created At</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" value="<?=$data->createdAt?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Created By</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" value="<?=$data->createdBy?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">Status</label>
                    <div class="col-lg-9">
                        <select name="status" id="select2" class="select2-selection__rendered">
                            <option></option>
                            <option value="akt">Aktif</option>
                            <option value="nonakt">NonAktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="batal()">Batal</button>
                <button type="button" class="btn btn-submit me-2" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->