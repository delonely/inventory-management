<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">

<div class="page-wrapper">
	<div class="content">
		<div class="page-header">
			<div class="page-title">
				<h4>List Unit</h4>
				<h6>Menu Kelola Unit</h6>
			</div>
			<div class="page-btn">
				<button class="btn btn-added" type="button" onclick="tambah()"><img src="<?=base_url('assets/img/icons/plus.svg')?>" alt="img" class="me-1"> Tambah Unit</button>	
			</div>
		</div>
	
		<!-- Tabel List Unit -->
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
								<th>Id Unit</th>
								<th>Nama Unit</th>
								<th>Status</th>
								<th>AT</th>
								<th>BY</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!--End Table List Unit -->
        <!--start modal unit-->
        <div class="viewmodal" style="display:none;">
        </div>
	</div>
</div>
<!-- /Main Wrapper -->
<?php include 'Addunit.php';?>




