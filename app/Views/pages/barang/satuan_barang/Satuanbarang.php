<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">

<div id="global-loader" >
	<div class="whirly-loader"> </div>
</div>
<!-- Main Wrapper -->
<div class="main-wrapper">
	<div class="page-wrapper">
		<div class="content">
			<div class="page-header">
				<div class="page-title">
					<h4>Satuan Barang</h4>
					<h6>Menu Kelola Satuan Barang</h6>
				</div>
				<div class="page-btn">
					<button class="btn btn-added" type="button" onclick="tambah()"><img src="<?=base_url('assets/img/icons/plus.svg')?>" alt="img" class="me-1">Tambah Satuan Barang</button>
				</div>
			</div>
			
			<!-- Satuan Barang -->
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
									<th>Id Satuan</th>
									<th>Nama Satuan</th>
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
			<!-- /Satuan barang -->
			<!--start modal-->
			<div class="viewmodal" style="display: none;">
			</div>	
		</div>
	</div>
</div>
<!-- /Main Wrapper -->

<!--Modal-->
<?php include 'Addsatuan.php';?>
