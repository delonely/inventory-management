<div class="col-md-5">
	<form id="formSimpanBarang" class="row g-3 needs-validation" novalidate>
		<div class="card">
			<div class="card-header">
				<button class="btn btn-primary" id="dataBarang" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBarang" aria-expanded="false" aria-controls="collapseBarang">- Data Barang</button>
			</div>
			<div class="collapse show" id="collapseBarang">
				<div class="card-body">
					<div class="form-group">
						<label>Nama Barang</label>
						<!-- <= isset($barang['dataBarang']->namaBarang) ? $barang['dataBarang']->namaBarang : "" ?> -->
						<input type="text" id="namaBrg" class="form-control" name="nama" value="" required>
						<div class="valid-feedback">Nama Barang Sesuai</div>
						<div class="invalid-feedback">Mohon Isi Nama Barang.</div>
						<input type="hidden" name="dataId" id="dataId" value="0" />
					</div>
					<div class="form-group">
						<label>Kategori Barang</label>
						<select name="idKategori" id="kategori" class="kategori" aria-label="kategori select" required>
						</select>
						<div class="valid-feedback">Kategori Terpilih</div>
						<div class="invalid-feedback">Mohon Pilih Salah Satu Kategori.</div>
					</div>
					<div class="form-group">
						<label>Satuan Pengadaan</label>
						<select name="satuanPengadaan" id="satuanPengadaan" class="satuan" aria-label="satuanPengadaan select" required>
						</select>
						<div class="valid-feedback">Satuan Pengadaan Sesuai</div>
						<div class="invalid-feedback">Mohon Isi Satuan Pengadaan.</div>
					</div>
					<div class="form-group">
						<label>Satuan Terkecil</label>
						<select name="satuanTerkecil" id="satuanTerkecil" class="satuan" aria-label="satuanTerkecil select" required>
						</select>
						<div class="valid-feedback">Satuan Terkecil Sesuai</div>
						<div class="invalid-feedback">Mohon Isi Satuan Terkecil.</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>