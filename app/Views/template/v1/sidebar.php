<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li>
					<a href="<?= site_url('/') ?>" class="<?= $page == 'home' ? "active" : ""; ?>"><img src="<?= base_url('assets/img/icons/dashboard.svg') ?>" alt="img"><span>Dashboard </span> </a>
				</li>
				<!--side data barang-->
				<?php if ($_userData['roleid'] == 1 || $_userData['isGudang']) { ?>
					<li class="submenu">
						<!--sidebar barang-->
						<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/product.svg') ?>" alt="img"><span> Barang</span> <span class="menu-arrow"></span></a>
						<ul>
							<!--sidebar kelola kategori barang-->
							<?php if ($_userData['roleid'] == 1) { ?>
								<li><a href="<?= site_url('Kategoribarang') ?>" class="<?= $page == 'kategori' ? "active" : ""; ?>">Kelola Kategori Barang</a></li>
								<li><a href="<?= site_url('Satuanbarang') ?>" class="<?= $page == 'satuan' ? "active" : ""; ?>">Kelola Satuan Barang</a></li>

							<?php
							}
							?>
								<li><a href="<?= site_url('Databarang') ?>" class="<?= $page == 'barang' ? "active" : ""; ?>">Kelola Data Barang</a></li>
						</ul>
					</li>
				<?php } ?>
				<!--side data pajak-->
				<?php if ($_userData['roleid'] == 1) { ?>
					<li class="submenu">
						<!--sidebar pajak-->
						<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/expense1.svg') ?>" alt="img"><span>Pajak</span> <span class="menu-arrow"></span></a>
						<ul>
							<!--sidebar kelola pajak-->
							<li><a href="<?= site_url('Pajak') ?>" class="<?= $page == 'pajak' ? "active" : ""; ?>">Kelola Pajak</a></li>
						</ul>
					</li>
					
					<li class="submenu">
						<!--sidebar barang-->
						<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/product.svg') ?>" alt="img"><span> Supplier</span> <span class="menu-arrow"></span></a>
						<ul>
							<!--sidebar kelola kategori barang-->
							<li><a href="<?= site_url('Kategorisupplier') ?>" class="<?= $page == 'kategorisupplier' ? "active" : ""; ?>">Kelola Kategori Supplier</a></li>
							<li><a href="<?= site_url('Supplier') ?>" class="<?= $page == 'datasupplier' ? "active" : ""; ?>">Kelola Data Supplier</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if ($_userData['roleid'] == 1 || $_userData['isGudang']) { ?>
				<li class="submenu">
					<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/purchase1.svg') ?>" alt="img"><span>Purchasing</span> <span class="menu-arrow"></span></a>
					<ul>
						<!--sidebar persediaan (request barang)-->
						<li><a href="<?= site_url('Purchase') ?>" class="<?= $page == 'pembelian' ? "active" : ""; ?>">Pembelian Barang</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="submenu">
					<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/sales1.svg') ?>" alt="img"><span> Persediaan</span> <span class="menu-arrow"></span></a>
					<ul>
						<!--sidebar persediaan (request barang)-->
						<li><a href="<?= site_url('Permintaanbarang') ?>" class="<?= $page == 'permintaan' ? "active" : ""; ?>">Permintaan Barang</a></li>
					</ul>
				</li>
				<?php if ($_userData['roleid'] == 1 || $_userData['isGudang']) { ?>
					<li class="submenu">
						<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/time.svg') ?>" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?= site_url('LapPosisiPersediaan') ?>" class="<?= $page == 'lapPosisiPersediaan' ? "active" : ""; ?>">Laporan Posisi Persediaan di Neraca</a></li>
							<li><a href="<?= site_url('LapPersediaan') ?>" class="<?= $page == 'lapPersediaan' ? "active" : ""; ?>">Laporan Persediaan</a></li>
							<li><a href="<?= site_url('LapRincianPersediaan') ?>" class="<?= $page == 'lapRincianPersediaan' ? "active" : ""; ?>">Laporan Rincian Persediaan</a></li>
						</ul>
					</li>
				<?php } ?>
				<?php if ($_userData['roleid'] == 1) { ?>
				<li class="submenu">
					<a href="javascript:void(0);"><img src="<?= base_url('assets/img/icons/users1.svg') ?>" alt="img"><span> Pengguna</span> <span class="menu-arrow"></span></a>
					<ul>
						<li><a href="<?= site_url('Unit') ?>" class="<?= $page == 'unit' ? "active" : ""; ?>">Kelola Unit Pengguna</a></li>
						<li><a href="<?= site_url('User') ?>" class="<?= $page == 'user' ? "active" : ""; ?>">Kelola Data Pengguna</a></li>
					</ul>

				</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->