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
					<h4>Pembelian Barang</h4>
					<h6>Menu Pembelian Barang</h6>
				</div>
				<div class="page-btn">
					<!-- data-bs-toggle="modal" data-bs-target="#addkategorimodal"-->
					<a href="<?=site_url("Purchase/addPurchase")?>" class="btn btn-added" type="button" ><img src="<?=base_url('assets/img/icons/plus.svg')?>" alt="img" class="me-1">Tambah Pembelian Barang</a>
				</div>
			</div>

			<!-- Tabel Kategori Barang -->
			<div class="card">
				<div class="card-body">
					<div class="table-top">
						<div class="search-set">
							<div class="search-input">
								<a class="btn btn-searchset"><img src="<?=base_url('assets/img/icons/search-white.svg')?>" alt="img"></a>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table id="tabel" class="table datanew table-striped table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Id Purchase</th>
									<th>Nomor Nota</th>
									<th>Nama Unit</th>	
									<th>Nama User</th>							
									<th>Total Harga</th>
									<th>Status</th>
									<th>Tanggal Nota</th>
									<th>created At</th>
									<th>created By</th>	
									<th>action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /Tabel Kategori barang -->
			<!--start modal-->
			<!-- <div class="viewmodal" style="display: none;">
			</div> -->
		</div>
	</div>
</div>
<!-- /Main Wrapper -->
