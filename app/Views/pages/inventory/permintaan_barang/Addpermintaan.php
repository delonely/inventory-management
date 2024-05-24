<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/css/jquery.dataTables.min.css')?>">

<style> 
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: none;
    border-color:  transparent; 
    } 

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
      background: none;
      border-color: transparent;
      color: transparent!important;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Permintaan Barang</h4>
                <h6>Silahkan mengisi form ini untuk meminta barang</h6>
            </div>
        </div>
        <form id="formPermintaan" class="row g-3 needs-validation" novalidate>
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Klien</label> 
                            <div class="col-md-12">
                                <select name="client" id="client" class="select2-selection__rendered" aria-label="assign select" required>
                                    <option></option>
                                </select> 
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Tanggal Permintaan </label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" id="datetimepicker2" name="tglPermintaan">
                                <div class="addonset">
                                    <img src="<?=base_url('assets/img/icons/calendars.svg')?>" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="dataId" id="dataId" value="0" />
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <input type="text" name="cariBrg" id="cariBrg" class="form-control" disabled>
                                    </div>
                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                        <div class="add-icon">
                                            <a href="javascript:void(0);" onclick="cari()"><img src="<?= base_url('assets/img/icons/plus1.svg') ?>" alt="img" ></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-4 col-4">
                            <div class="form-group">
                                <label>Satuan</label>
                                <select name="satuanBrg" id="satuanBrg" class="satuan" aria-label="satuanBrg select" required disabled>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-4 col-4">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" id="jumlah" name="jumlah" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-6">
                            <div class="form-group">
                                <label>Stok</label>
                                <div class="col-lg-5 col-sm-6 col-12">
                                    <input type="text" id="stokBrg" name="stok" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-submit me-2" id="tambah" onclick="tambahBrg()" disabled>Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table id="tabelPermintaan" class="table datanew table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Permintaan</th>
                                    <th>Satuan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button type="button" class="btn btn-submit me-2" id="simpanPermintaan" onclick="simpanPermintaan()" disabled>Selesai</button>
                    <button type="button" class="btn btn-cancel" onclick="batalPermintaan()">Batal</a>
                </div>
            </div>
        </div>
    </div>
    <div class="viewmodal" style="display: none;">
    </div>
</div>

<?php include 'Caribarang.php' ?>
<!-- /Main Wrapper -->