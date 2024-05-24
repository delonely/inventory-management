<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Menu Cetak Laporan Posisi Persediaan di Neraca</h4>
                <h6>Silahkan pilih tanggal cetak</h6>
            </div>
        </div>
        <form id="formCetakPosisi" class="row g-3 needs-validation" novalidate>
            <div class="card">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Laporan s/d Tanggal: </label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" id="datetimepicker2" name="tglCetakPosisi">
                                <div class="addonset">
                                    <img src="<?=base_url('assets/img/icons/calendars.svg')?>" alt="img">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-submit me-2" onclick="cetakLapPosisi()">Unduh</button>
                        <button type="button" class="btn btn-cancel" onclick="keluar()">Keluar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
<!-- /Main Wrapper -->