<div class="page-wrapper cardhead">
	<div class="content container-fluid">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col">
					<h3 class="page-title">Tambah Data Barang</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active">Menu Kelola Data Barang</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		<div class="card">
			<div class="card-body">
				<div class="row">
					<?php
					include 'addData/dataBarang.php';
					include 'addData/dataKonversi.php';
					if (isset($barang['dataBarang']->namaBarang)) {
					include 'addData/dataGudang.php';
					}
					?>
					<div class="col-lg-12">
						<button class="btn btn-submit me-2" id="pensubmit" onclick="simpan()">Simpan</button>
						<button class="btn btn-cancel" onclick="batal()">Batal</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>