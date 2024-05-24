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
                <h4>Pembelian Barang</h4>
                <h6>Silahkan mengisi form pembelian barang</h6>
            </div>
        </div>
        <form id="formSupplier" class="row g-3 needs-validation" novalidate>
            <div class="card">
                <div class="card-header">
					<button class="btn btn-primary" id="dataNota" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNota" aria-expanded="false" aria-controls="collapseNota">- Data Nota</button>
				</div>
                <div class="collapse show" id="collapseNota">	
                    <div class="card-body">
                    <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>No Nota</label>
                                    <div class="row">
                                        <div class="col-lg-11 col-sm-10 col-12">
                                            <input type="text" name="noNota" id="noNota" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tanggal Nota </label>
                                    <div class="input-groupicon">
                                        <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" id="datetimepicker2" name="tglNota">
                                        <div class="addonset">
                                            <img src="<?=base_url('assets/img/icons/calendars.svg')?>" alt="img">
                                        </div>
                                    </div>
                                </div>
							</div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Jenis Pajak</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <input type="text" name="namaPajak" id="namaPajak" class="form-control" disabled>
                                        </div>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="add-icon">
                                                <a href="javascript:void(0);" onclick="cariPajak()"><img src="<?=base_url('assets/img/icons/plus1.svg')?>" alt="img"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-2">
                                <div class="form-group">
                                    <label>Persen</label>
                                    <input type="text" name="persen" id="persen" class="form-control" disabled>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <input type="hidden" name="dataId" id="dataId" value="0"/>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Supplier</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <input type="text" name="namaSupplier" id="namaSupplier" class="form-control" disabled>
                                        </div>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="add-icon">
                                                <a href="javascript:void(0);" onclick="cariSupp()"><img src="<?=base_url('assets/img/icons/plus1.svg')?>" alt="img"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Kategori Supplier</label>
                                    <input type="text" name="kategoriSupp" id="kategoriSupp" class="form-control" disabled>
                                </div>
                            </div>  
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Alamat Supplier</label>
                                    <input type="text" name="alamatSupp" id="alamatSupp" class="form-control" disabled>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>No.Telp Supplier</label>
                                    <input type="text" name="telpSupp" id="telpSupp" class="form-control" disabled>
                                </div>
                            </div>             
                        </div>
                        </form>	
                    </div>
                </div>    
            </div>
        </form>
        <form id="formPembelian" class="row g-3 needs-validation" novalidate>
            <div class="card">
                <div class="card-header">
					<button class="btn btn-primary" id="dataBarang" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBarang" aria-expanded="false" aria-controls="collapseBarang">- Data Barang</button>
				</div>
                <div class="collapse show" id="collapseBarang">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="dataId" id="dataId" value="0"/>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-10 col-10">
                                            <input type="text" name="namaBrg" id="namaBrg" class="form-control" disabled>
                                        </div>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="add-icon">
                                                <a href="javascript:void(0);" onclick="cariBarang()"><img src="<?=base_url('assets/img/icons/plus1.svg')?>" alt="img"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-4 col-4">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select name="satuanBrg" id="satuanBrg" class="satuan" aria-label="satuanBrg select" disabled>
                                    </select>
                                </div>
                            </div>    
                            <div class="col-lg-2 col-sm-4 col-4">
                                <div class="form-group">
                                    <label>Jumlah Barang</label>  
                                        <input type="text" id="jumlah" name="jumlah" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-3 col-3">
                                <div class="form-group">
                                    <label>Harga Satuan</label>  
                                        <input type="text" id="hargaSat" name="hargaSat" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-3 col-3">
                                <div class="form-group">
                                    <label>Total harga</label>  
                                        <input type="text" id="total" name="total" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-submit me-2" id="tambah" onclick="tambahBrg()" >Tambah</button>
                            </div>	     
                        </div>
                        </form>	
                    </div>
                </div>
            </div>
        </form>
        <!-- <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        total sebelum pajak : <x id="sebepa"></x> 
                    </div>
                    <div class="col-md-6">
                total setelah pajak : <x id="sesupa"></x>
                </div>
            </div>
        </div> -->
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                     <table id="tabelPembelian" class="table datanew table-striped table-bordered" >
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Pembelian</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 float-md-right">
                        <div class="total-order">
                            <ul>
                                <li>
                                    <h4>Jumlah:</h4>
                                    <h5 id="sebepa"></h5>
                                </li>
                                <li>
                                    <h4>Pajak:</h4>
                                    <h5 id="pajak"></h5>
                                </li>
                                <li>
                                    <h4>Total Harga + Pajak:</h4>
                                    <h5 id="sesupa"></h5>
                                </li>	
                            </ul>
                        </div>
                    </div>
		      </div>
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-submit me-2" id="simpanPurchase" onclick="simpanPembelian()" disabled>Simpan</button>
                        <button type="button" class="btn btn-cancel" onclick="batalPembelian()">Batal</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="viewmodal" style="display: none;">
		</div>
    </div>
</div>
<?php include 'Carisupplier.php'?>
<?php include 'Caribarang.php'?>
<?php include 'Caripajak.php'?>
		<!-- /Main Wrapper -->