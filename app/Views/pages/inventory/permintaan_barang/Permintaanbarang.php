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
					<h4>Permintaan Barang</h4>
					<h6>Menu Permintaan Barang</h6>
				</div>
				<?php if ($_userData['roleid'] == 1 || $_userData['isGudang']) { ?>
				<div class="page-btn">
					<!-- data-bs-toggle="modal" data-bs-target="#addkategorimodal"-->
					<a href="<?=site_url("Permintaanbarang/addPermintaanBarang")?>" class="btn btn-added" type="button" ><img src="<?=base_url('assets/img/icons/plus.svg')?>" alt="img" class="me-1">Tambah Permintaan Barang</a>
				</div>
				<?php } ?>
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
									<th>Id Request</th>
									<th>Tanggal Request</th>							
									<th>Nomor Request</th>
									<th>Nama Unit</th>
									<th>Nama User</th>
									<th>Status</th>
									<th>Created At</th>
									<th>Created By</th>
									<th>Action</th>
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
			<div class="viewmodal" style="display: none;">
			</div>
		</div>
	</div>
</div>
<!-- /Main Wrapper -->
