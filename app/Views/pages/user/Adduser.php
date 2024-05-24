<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Data Pengguna</h4>
                <h6>Menu Kelola Data Pengguna</h6>
            </div>
        </div>
        <!-- /add -->
        <form id="formUser" class="row g-3 needs-validation" novalidate>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <input type="hidden" name="dataId" id="dataId" value="0"/>
                        <div class="col-lg-3 col-sm-6 col-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="namaUser" id="namaUser" >
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" id="username" class="form-control" >
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" id="unit" class="select2-selection__rendered" aria-label="unit select" required>
                                    <option></option>
                                </select>
                                <div class="valid-feedback">Nama Unit Terpilih.</div>
                                <div class="invalid-feedback">Mohon Pilih Unit.</div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class=" pass-input" name="password" id="password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" id="role" class="select2-selection__rendered" aria-label="role select" required>
                                    <option></option>
                                </select>
                                <div class="valid-feedback">Role Terpilih.</div>
                                <div class="invalid-feedback">Mohon Pilih Role.</div>
                            </div>   
                            <div class="form-group">
                                <label>Tanggal</label>
                                <div class="input-groupicon">
                                    <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" id="datetimepicker2" name="tgl">
                                    <div class="addonset">
                                        <img src="<?=base_url('assets/img/icons/calendars.svg')?>" alt="img">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-submit me-2" onclick="simpanUser()">Simpan</button>
                            <button type="button" class="btn btn-cancel" onclick="batalUser()">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>    
        <!-- /add -->
        <!-- <div class="viewmodal" style="display: none;"> -->
    </div>
</div>
