<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">

<div class="page-wrapper">
	<div class="content">
		<div class="page-header">
			<div class="page-title">
				<h4>List Pengguna</h4>
				<h6>Menu Kelola Pengguna</h6>
			</div>
			<div class="page-btn">
				<a href="<?=site_url("User/addUser")?>" class="btn btn-added" type="button" ><img src="<?=base_url('assets/img/icons/plus.svg')?>" alt="img" class=
				"me-1">Tambah Data Pengguna</a>
			</div>
		</div>
	
		<!-- Tabel List Pengguna -->
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
								<th>Id User</th>
								<th>Id Unit</th>
								<th>Username </th>
								<th>Nama Pengguna</th>
								<th>Role</th>
								<th>Nama Unit</th>
								<th>Tanggal Mutasi</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--End Table User -->
		<div class="viewmodal" style="display: none;">
	</div>
</div>
<!-- /Main Wrapper -->
<?php include 'Mutasiuser.php';?>
<?php include 'Edituser.php';?>



