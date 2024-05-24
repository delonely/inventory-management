<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">

<div class="col-md-12">
    <form id="formSimpanGudang" class="row g-3 needs-validation" novalidate>
        <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" id="dataGudang" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGudang" aria-expanded="false" aria-controls="collapseGudang">- Data Gudang</button>
        </div>
            <div class="collapse show" id="collapseGudang">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" id="unit" class="unitGudang" required>
                                    <option></option>
                                </select>
                                <div class="valid-feedback">Nama Unit Terpilih.</div>
                                <div class="invalid-feedback">Mohon Pilih Unit.</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Stok Minimal</label>
                                <div class="input-group">
                                    <input type="number" name="stokMinimal" id="stokMinimal" class="form-control" required/>
                                    <span class="input-group-text satTerkecil"> - </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Satuan Request Default</label>
                                    <select name="satuanRequest" id="satuanRequest" class="satuan" aria-label="konversi select" required>
                                    </select>
                                <div class="valid-feedback">Satuan Request Sesuai</div>
                                <div class="invalid-feedback">Mohon Pilih Satuan Request.</div>                           
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                    <label>Stok Awal</label>
                                    <div class="input-group">
                                        <input type="number" name="stokAwal" id="stokAwal" class="form-control" required/>
                                        <span class="input-group-text satTerkecil"> - </span>
                                    </div>
                                </div>
                            </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Harga Saldo Awal</label>
                                <input type="number" name="hSaldoAwal" id="hSaldoAwal" class="form-control" required/>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                        <button class="btn btn-primary" type="button" name="konversi" id="konversi" onclick="simpanGudang()">Tambah</button>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="tabelGudang" class="table datanew table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id unit</th>
                                        <th>Id request</th>
                                        <th>Stok</th>
                                        <th>Nama Unit</th>
                                        <th>Stok Minimal</th>
                                        <th>Satuan Request</th>
                                        <th>Stok Awal</th>
                                        <th>Harga Saldo Awal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

