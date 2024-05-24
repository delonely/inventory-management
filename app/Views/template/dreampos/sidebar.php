<body>
    <!-- Sidebar -->
			<div class="sidebar" id="sidebar">
				<div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="<?= $page=='home'?  "active" : ""; ?>">
								<a href="home.php" ><img src="<?=base_url('/img/icons/dashboard.svg')?>" alt="img"><span>Dashboard </span> </a>
							</li>
							<li class="submenu">
								<!--sidebar barang-->
								<a href="javascript:void(0);"><img src="<?=base_url('/img/icons/product.svg')?>" alt="img"><span> Barang</span> <span class="menu-arrow"></span></a>
								<ul>
									<!--sidebar kelola kategori barang-->
									<li><a href="Kategoribarang" class="<?= $page=='kategori'? "active" : ""; ?>">Kelola Kategori Barang</a></li>
									<li><a href="Satuanbarang" class="<?= $page=='satuan'? "active" : ""; ?>">Kelola Satuan Barang</a></li>
									<li><a href="categorylist.html">Category List</a></li>
									<li><a href="SubCategorylist.html">Sub Category List</a></li>
									<li><a href="subaddcategory.html">Add Sub Category</a></li>
									<li><a href="brandlist.html">Brand List</a></li>
									<li><a href="addbrand.html">Add Brand</a></li>
									<li><a href="importproduct.html">Import Products</a></li>
									<li><a href="barcode.html">Print Barcode</a></li>
								</ul>
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="<?=base_url('/img/icons/time.svg')?>" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
								
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="<?=base_url('/img/icons/users1.svg')?>" alt="img"><span> Users</span> <span class="menu-arrow"></span></a>
								
							</li>
							<li class="submenu">
								<a href="javascript:void(0);"><img src="<?=base_url('/img/icons/settings.svg')?>" alt="img"><span> Settings</span> <span class="menu-arrow"></span></a>
								
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Sidebar -->
</body>