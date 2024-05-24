<link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap4.min.css') ?>">

<div id="global-loader">
	<div class="whirly-loader"></div>
</div>
<!-- Main Wrapper -->
<div class="main-wrapper">
	<div class="page-wrapper">
		<div class="content">
			<div class="page-header">
				<div class="page-title">
					<h4>Data Barang</h4>
					<h6>Menu Kelola Data Barang</h6>
				</div>
				<?php if ($_userData['roleid'] == 1) { ?>
					<div class="page-btn">
						<a href="<?= site_url("Databarang/add") ?>" class="btn btn-added" type="button"><img src="<?= base_url('assets/img/icons/plus.svg') ?>" alt="img" class="me-1">Tambah Data Barang</a>
					</div>
				<?php } ?>
			</div>

			<!-- Data Barang -->
			<div class="card">
				<div class="card-body">
					<div class="table-top">
						<div class="search-set">
							<div class="search-input">
								<a class="btn btn-searchset"><img src="<?= base_url('assets/img/icons/search-white.svg') ?>" alt="img"></a>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table id="tabel" class="table datanew table-striped table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Id Barang</th>
									<th>Id kategori Barang</th>
									<th>Nama Kategori</th>
									<th>Nama Barang</th>
									<?php
									if ($_userData['roleid'] == 2) {  ?>
										<th>Estimasi Stok</th>
									<?php } ?>
									<th>ID Satuan Terkecil</th>
									<th>ID Satuan Pengadaan</th>
									<th>Satuan Terkecil</th>
									<th>Satuan Pegadaan</th>
									<th>Status</th>
									<?php
									if ($_userData['roleid'] == 1) {  ?>
										<th>Action</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /Satuan barang -->
			<div class="viewmodal" style="display: none;">
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->