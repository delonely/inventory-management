<div class="modal fade" id="editusermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Detail Pengguna</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;</button>
            </div>
            <form id="formEdit" class="row g-3 needs-validation" novalidate>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nama</label>
                        <div class="col-md-9">
                            <input type="text" name="namaUserEdit" id="namaUserEdit" class="form-control">
                        </div>
                        <input type="hidden" name="dataIdEdit" id="dataIdEdit" value="0" />
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Username</label>
                        <div class="col-md-9">
                        <input type="text" name="usernameEdit" id="usernameEdit" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Password</label>
                        <div class="col-md-9">
                            <div class="pass-group">
                                <input type="password" class=" pass-input" name="passwordEdit" id="passwordEdit">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Role</label>
                        <div class="col-md-9">
                            <select name="roleEdit" id="roleEdit" class="select2-selection__rendered" aria-label="role select" required>
                                <option></option>
                            </select>
                            <div class="valid-feedback">Role Terpilih.</div>
                            <div class="invalid-feedback">Mohon Pilih Role.</div>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit me-2" id="pensubmitEdit" onclick="simpanEdit()">Simpan</button>
                    <button type="button" class="btn btn-cancel" onclick="batal()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal-->