<link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap4.min.css') ?>">

<div class="col-md-7">
    <form id="formSimpanKonversi" class="row g-3 needs-validation" novalidate>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="dataSatuan" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSatuan" aria-expanded="false" aria-controls="collapseSatuan">- Data Konversi Satuan</button>
            </div>
            <div class="collapse show" id="collapseSatuan">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-text"> 1 </span>
                                    <select name="konversi" id="konversi" class="form-control" aria-label="konversi select" required>
                                    </select>
                                    <div class="valid-feedback">Konversi Sesuai</div>
                                    <div class="invalid-feedback">Mohon Pilih Konversi.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label> = </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="jumlah" id="jmlKonversi" class="form-control" required />
                                    <span class="input-group-text satTerkecil"> - </span>
                                    <div class="col-lg-40 col-sm-4 col-2 ps-4">
                                        <div class="add-icon">
                                            <a href="javascript:void(0);" onclick="simpanKonversi()" name="konversi" id="konversi"><img src="<?= base_url('assets/img/icons/plus1.svg') ?>" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tabelKonversi" class="table datanew table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id Konversi</th>
                                <th>Id Konversi Satuan</th>
                                <th>Satuan</th>
                                 <th>Jumlah Konversi</th>
                                <th>Satuan Konversi</th> 
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>