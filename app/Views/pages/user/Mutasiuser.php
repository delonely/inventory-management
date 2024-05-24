<div class="modal fade" id="mutasimodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Mutasi</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;</button>
            </div>
            <form id="formMutasi" class="row g-3 needs-validation" novalidate>
                <div class="modal-body">
                <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama</label>
                        <div class="col-md-9">
                            <input type="text" name="namaUser" id="namaUser" class="form-control" disabled>
                        </div>
                        <input type="hidden" name="dataId" id="dataId" value="0" />
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Unit Mutasi</label>
                        <div class="col-md-9">
                            <select name="idUnit" id="idUnit" class="select2-selection__rendered" required>
                                <option></option>
                            </select>
                            <div class="valid-feedback">Nama Unit Terpilih.</div>
                            <div class="invalid-feedback">Mohon Pilih Unit.</div>
                        </div> 
                    </div> 
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Mutasi</label>
                        <div class="col-md-9">
                            <div class="input-groupicon">
                                <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" id="datetimepicker2" name="tglMutasi">
                                <div class="addonset">
                                    <img src="<?=base_url('assets/img/icons/calendars.svg')?>" alt="img">
                                </div>
                            </div>
                        </div> 
                    </div>                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit me-2" id="pensubmit" onclick="simpanMutasi()">Simpan</button>
                    <button type="button" class="btn btn-cancel" onclick="batal()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal-->