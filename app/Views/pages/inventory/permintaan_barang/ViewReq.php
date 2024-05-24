<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">

<div id="global-loader">
	<div class="whirly-loader"> </div>
</div>
<!-- Main Wrapper -->
<div class="main-wrapper">
	<div class="page-wrapper">
		<div class="content">
			<div class="page-header">
			
				<div class="page-title">
					<h4>View Request</h4>
					<h6>Menu Tampilan Data Pesanan</h6>
				</div>
			</div>

			<!-- Tabel Kategori Barang -->
			<div class="card">
				<div class="card-body">
					<input type="hidden" name="dataId" id="dataId" value="0"/>
					<div class="table-top">
						<div class="search-set">
							<div class="search-input">
								<a class="btn btn-searchset"><img src="<?=base_url('assets/img/icons/search-white.svg')?>" alt="img"></a>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table id="tabelViewReq" class="table datanew table-striped table-bordered" width="100%">
							<thead>
								<tr>
									<th>Id Barang</th>
									<th>Id Detail Request</th>
									<th>Id Satuan Barang</th>
									<th>Nama Barang</th>
									<th>Jumlah Permintaan</th>
									<th>Satuan Permintaan</th>				
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-6">
					<button type="button" class="btn btn-cancel" onclick="kembali()">Kembali</a>
                </div>
			</div>
			<!-- /Tabel Kategori barang -->
			<!--start modal-->
			<div class="viewmodal" style="display: none;">
			</div>
		</div>
	</div>
</div>
<!-- /Main Wrapper -->

