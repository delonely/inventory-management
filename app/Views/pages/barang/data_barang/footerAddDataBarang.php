<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalerts.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.js') ?>"></script>

<script>
	/**
	 * Start for collapse button
	 */
	$('#dataBarang').click(function() {
		$(this).text(function(i, old) {
			return old == '- Data Barang' ? '+ Data Barang' : '- Data Barang';
		});
	});

	$('#dataSatuan').click(function() {
		$(this).text(function(i, old) {
			return old == '- Data Konversi Satuan' ? '+ Data Konversi Satuan' : '- Data Konversi Satuan';
		});
	});

	$('#dataGudang').click(function() {
		$(this).text(function(i, old) {
			return old == '- Data Gudang' ? '+ Data Gudang' : '- Data Gudang';
		});
	});
	/*End collapse button*/

	/** Start Select2 */
	$('#unit').select2({
		placeholder: "Pilih Unit",
		disabled: false,
		ajax: {
			url: "<?= site_url('Unit/select') ?>",
			dataType: 'json',
			method: 'get',
			data: function(term, page) {
				return {
					q: term, //Search Term
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.nama,
							id: item.id
						}
					})
				};
			}
		}
	});

	$('.kategori').select2({
		placeholder: "Pilih Kategori",
		disabled: false,
		ajax: {
			url: "<?= site_url('Kategoribarang/select') ?>",
			dataType: 'json',
			method: 'get',
			data: function(term, page) {
				return {
					q: term
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.nama,
							id: item.id
						}
					})
				};
			}
		}
	});

	$('.satuan').select2({
		placeholder: "Pilih Satuan",
		disabled: false,
		ajax: {
			url: "<?= site_url('Satuanbarang/select') ?>",
			dataType: 'json',
			method: 'get',
			data: function(term, page) {
				return {
					q: term
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.nama,
							id: item.id
						}
					})
				};
			}
		}
	});

	function initSelectSatuan(id){
		$('#satuanRequest').select2({
			placeholder: "Pilih Satuan",
			disabled: false,
			ajax: {
				url: "<?= site_url('Satuanbarang/terkecil') ?>/"+id,
				dataType: 'json',
				type: 'get',
				data: function(term, page) {
					return {
						q: term
					};
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: item.nama,
								id: item.id
							}
						})
					};
				}
			}
		});
	}

	$('#satuanTerkecil').select2({
		placeholder: "Pilih Satuan",
		disabled: false,
		ajax: {
			url: "<?= site_url('Satuanbarang/select') ?>",
			dataType: 'json',
			method: 'get',
			data: function(term, page) {
				return {
					q: term
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.nama,
							id: item.id
						}
					})
				};
			}
		}
	});

	$('#satuanTerkecil').on('select2:select', function(e) {
		var data = e.params.data;
		$(".satTerkecil").html(data.text);
	});

	$('#konversi').select2({
		placeholder: "Pilih Satuan",
		disabled: false,
		ajax: {
			url: "<?= site_url('Satuanbarang/select') ?>",
			dataType: 'json',
			method: 'get',
			data: function(term, page) {
				return {
					q: term
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.nama,
							id: item.id
						}
					})
				};
			}
		}
	});
	/**End Select2 Dropwdown */

	/**
	 * Start insert data into konversi datatable
	 * save as array and added it into datatable
	 */
	var listKonversi = [];
	var tabelKonversi;

	function simpanKonversi() {
		jmlKonversi = document.getElementById('jmlKonversi').value;
		idKonversi = $("#konversi").val();
		valKonversi = $("#konversi option:selected").text();
		satuanDasar = $("#satuanTerkecil option:selected").text();

		$('#konversi').val('').trigger("change");
		$('#jmlKonversi').val('').trigger("change");

		var found = 0
		for (var arr in listKonversi) { //check if there is a data with same value
			if (listKonversi[arr]['idKonversiSatuan'] == idKonversi)
				found = 1;
		}

		if (found == 1) { //if there is data with same value, pop up alert
			alert("Data konversi sudah ada");
			return;
		}

		listKonversi.push({ //push into array
			idKonversi: 0,
			idKonversiSatuan: idKonversi,
			konversiSatuan: valKonversi,
			jumlah: jmlKonversi,
			satuanTerkecil: satuanDasar
		});

		initTable();
		console.log(listKonversi);
	}

	/** Start Tabel Konversi before data is added into datatable */
	$('#tabelKonversi').DataTable({
		"processing": true,
		"serverSide": false,
		"autoWidth": false,
		"responsive": true,
		"bfilter": true,
		"sDom": 'ftlp',
		"paging": false,
		"ordering": true,
		"columnDefs": [{
			"targets": [0, 1],
			"orderable": false,
			"visible": false,
		}]
	});
	/*End Tabel Konversi design*/

	/**
	 * Start konversi datatable
	 * delete button for removing konversi from datatable
	 */

	function initTable() {
		tabelKonversi = $('#tabelKonversi').DataTable({
			"processing": true,
			"serverSide": false,
			"autoWidth": false,
			"responsive": true,
			"bfilter": true,
			"sDom": 'ftlp',
			"paging": false,
			"scrollY": '97px',
			"scrollCollapse": true,
			"ordering": false,
			"aaData": listKonversi,
			"aoColumns": [{
				"data": "idKonversi"
			}, {
				"data": "idKonversiSatuan"
			},{
				"data": "konversiSatuan"
			}, {
				"data": "jumlah"
			},{
				"data": "satuanTerkecil"
			}],
			"columnDefs": [{
				"targets": [0, 1],
				"orderable": false,
				"visible": false,
			}, {
				"targets": [5],
				"data": null,
				"defaultContent": '<button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><img src="<?= base_url('assets/img/icons/delete.svg') ?>" alt="img"></button></div>'
			}, {
				"className": "text-center",
				"targets": [2, 3, 4]
			}],
			"bDestroy": true
		});

		$('#tabelKonversi').on('click', '.btn-delete', function() {

			var data = tabelKonversi.row($(this).parents('tr')).data();

			if (data == null) return;

			var found = 0;
			for (let i = 0; i < listKonversi.length; i++) {

				if (listKonversi[i]['idKonversiSatuan'] == data['idKonversiSatuan']) {
					if (data['idKonversi'] == 0) {
						found = 1;
					} else {
						$.ajax({
							async: false,
							type: "delete",
							url: "<?= base_url('Databarang/satuan') ?>/" + data['idKonversi'],
							dataType: "json",
							success: function(response) {
								if (response.success == true) {
									console.log(response);
									found = 2;
								}
							}
						});
					}
					if (found == 1 || found == 2) {

						listKonversi.splice(i, 1);

						tabelKonversi
							.row($(this).parents('tr'))
							.remove()
							.draw();

						$('#tabelKonversi').dataTable().fnDeleteRow(data['idKonversiSatuan']);
						break;
					}
				}
			};
		});
	}
	/*End konversi*/

	/**
	 * Start insert data into gudang datatable
	 * save as array and added it into datatable
	 */
	var listGudang = [];
	var tabelGudang;

	function simpanGudang() {
		unit = $("#unit").val();
		unitText = $("#unit option:selected").text();
		stokMinimal = $("#stokMinimal").val();
		idSatuanRequest = $("#satuanRequest").val();
		satuanRequest = $("#satuanRequest option:selected").text();
		saldoAwal = $("#stokAwal").val();
		hargaAwal = $("#hSaldoAwal").val();

		$('#unit').val('').trigger("change");
		$('#stokMinimal').val('').trigger("change");
		$('#satuanRequest').val('').trigger("change");
		$('#stokAwal').val('').trigger("change");
		$('#hSaldoAwal').val('').trigger("change");

		var found = 0
		for (var arr in listGudang) { //check if there is a data with same value
			if (listGudang[arr]['unit'] == unit)
				found = 1;
		}

		if (found == 1) { //if there is data with same value, pop up alert
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": false,
				"progressBar": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": true,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
			toastr["error"]("Data unit sudah tersedia")
			return;
		}

		listGudang.push({ //push into array 
			unit: unit,
			idSatuanRequest: idSatuanRequest,
			unitText: unitText,
			stokMinimal: stokMinimal,
			satuanRequest: satuanRequest,
			saldoAwal: saldoAwal,
			hargaAwal: hargaAwal,
			stok: saldoAwal
		});
		console.log(listGudang);
		initTableGudang();
	}

	$('#tabelGudang').DataTable({
		"processing": true,
		"serverSide": false,
		"autoWidth": false,
		"responsive": true,
		"bfilter": true,
		"sDom": 'ftlp',
		"paging": false,
		"ordering": true,
		"columnDefs": [{
			"targets": [0, 1, 2],
			"orderable": false,
			"visible": false,
		}]
	});

	/**
	 * Start gudang datatable
	 * delete button for removing gudang from datatable
	 */
	function initTableGudang() {
		tabelGudang = $('#tabelGudang').DataTable({
			"processing": true,
			"serverSide": false,
			"autoWidth": false,
			"responsive": true,
			"bfilter": true,
			"sDom": 'ftlp',
			"paging": false,
			"scrollY": '100px',
			"scrollCollapse": true,
			"ordering": false,
			"aaData": listGudang,
			"aoColumns": [{
				"data": "unit"
			}, {
				"data": "idSatuanRequest"
			}, {
				"data": "stok"
			}, {
				"data": "unitText"
			}, {
				"data": "stokMinimal"
			}, {
				"data": "satuanRequest"
			}, {
				"data": "saldoAwal"
			}, {
				"data": "hargaAwal",
				"render": $.fn.dataTable.render.number( ',', '.', 2 , 'Rp. ')
			}],
			"columnDefs": [{
				"targets": [0, 1, 2],
				"orderable": false,
				"visible": false,
			}, {
				"targets": [8],
				"data": null,
				"defaultContent": '<button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><img src="<?= base_url('assets/img/icons/delete.svg') ?>" alt="img"></button></div>'
			}],
			"bDestroy": true
		});

		$('#tabelGudang').on('click', '.btn-delete', function() {
			var data = tabelGudang.row($(this).parents('tr')).data();
			var dataId = $("#dataId").val();
			if (data == null) return;

			var found = 0;
			for (let i = 0; i < listGudang.length; i++) {
				if (listGudang[i]['unit'] == data['unit']) {
					if (data['unit'] == 0) {
						found = 1;
					}else {

						var stok = parseInt(data['stok']);

						if (stok > 0) {
							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": false,
							"positionClass": "toast-top-right",
							"preventDuplicates": true,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
							}

							toastr["error"]("Gudang tidak dapat dinonaktifkan karena stok barang masih tersedia")
						}else{
							// Disini proses delete
							// PR
							// 1. kemungkinan bug Kalau tambah data barang, tambah gudang, terus delete hwhw
							// 2. Konfirmasi delete 
							//
							$.ajax({
								async: false,
								type: "delete",
								url: "<?= base_url("Databarang/gudang") ?>/"+data['unit']+"/"+dataId,
								data: {
									id: dataId
								},
								dataType: "json",
								success: function(response) {
									if (response.isSuccess == true) {
										console.log(response);
										found = 2;
									}
								}
							});
						}
					}
					if (found == 1 || found == 2) {

						listGudang.splice(i, 1);

						tabelGudang
							.row($(this).parents('tr'))
							.remove()
							.draw();

						$('#tabelGudang').dataTable().fnDeleteRow(data['unit']);
						break;

						console.log(listGudang);
					}
				}
			};
		});
	}
	/*End gudang*/

	/**
	 * Start for form Validasi
	 */
	function validasiForm() {
		var listValidasi = ['#namaBrg'];
		var isValid = true

		listValidasi.forEach(function(nama) {
			if ($(nama).val() == "") {
				$(nama).closest('.form-group').removeClass("was-validated").addClass("was-validated");
				isValid = false;
			}
		});

		if ($('#kategori').val() == null) {
			$('#kategori').closest('.form-group').removeClass("was-validated").addClass("was-validated");
			isValid = false;
		}

		if ($('.satuan').val() == null) {
			$('.satuan').closest('.form-group').removeClass("was-validated").addClass("was-validated");
			isValid = false;
		}

		// if ($('#unit').val() == null) {
		// 	$('#unit').closest('.form-group').removeClass("was-validated").addClass("was-validated");
		// 	isValid = false;
		// }

		return isValid;
	}
	/*End form validasi*/

	/**
	 * Start simpan data
	 */
	function simpan() {
		var formData = {};
		var dataId = $("#dataId").val();

		$("#formSimpanBarang").serializeArray().map(function(x) { //make an array
			formData[x.name] = x.value;
		});

		formData['satuanKonversi'] = listKonversi;
		formData['dataGudang'] = listGudang;

		$("#formSimpanSaldoAwal").serializeArray().map(function(x) {
			formData[x.name] = x.value;
		});

		if (validasiForm() == false) {
			Swal.fire({
				title: "Ada form yang belum terisi",
				icon: "warning",
				confirmButtonColor: "#3085d6",
				confirmButtonText: "Ok"
			})
			return;
		}else{
			Swal.fire({
				title: "Apakah anda ingin menyimpan?",
				icon: "question",
				showCancelButton: !0,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Simpan",
				cancelButtonText: "Tidak",
				customClass: {
					confirmButton: "btn btn-primary",
					cancelButton: "btn btn-danger ml-1"
				},
				heightAuto: false,
				width: '30em',
				allowOutsideClick: false,
				allowEscapeKey: false,
				buttonsStyling: !1
			}).then((result) => {
				if (result.isConfirmed) {
					var xData = JSON.stringify(formData);
					$.ajax({
						type: "POST",
						url: "<?= base_url("Databarang") ?>",
						data: {
							id: dataId,
							konten: xData
						},
						dataType: "json",
						success: function(response) {
							console.log(response);
							if (response.isSuccess == true) {
								Swal.fire({
										title: "Data berhasil tersimpan",
										icon: "success",
										customClass: {
											confirmButton: "btn btn-outline-success"
										},
										heightAuto: false,
										width: '30em',
										allowOutsideClick: false,
										allowEscapeKey: false,
										buttonsStyling: !1
									})
									.then(function() {
										window.history.back();
									});
							} else if (result.isDenied) {
								Swal.fire({
									title: "Data gagal tersimpan",
									icon: "error",
									customClass: {
										confirmButton: "btn btn-outline-error"
									},
									heightAuto: false,
									width: '30em',
									allowOutsideClick: false,
									allowEscapeKey: false,
									buttonsStyling: !1
								})
							}
						}
					});
				}
			})
		}
	}
	/*End simpan data*/

	/**
	 * Start batal
	 */
	function batal() {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Inputan anda tidak akan tersimpan",
			icon: "warning",
			showCancelButton: !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Batal Input",
			cancelButtonText: "Tidak",
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-danger ml-1"
			},
			heightAuto: false,
			allowOutsideClick: false,
			allowEscapeKey: false,
			width: '30em',
			buttonsStyling: !1
		}).then((result) => {
			if (result.isConfirmed) {
				window.history.back();
			}
		})
	}
	/*End batal */

	/**Function to put data in form when edit is clicked */
	$(document).ready(function() {
		var path = window.location.pathname.toString();
		var paths = path.split("/");

		if (paths.length == 5) {
			initSelectSatuan(paths[4]);
			$.ajax({
				type: "get",
				url: "<?= site_url('Databarang/') ?>" + paths[4],
				dataType: "json",
				success: function(response) {
					if (response.success == true) {
						var dataBarang = response.result.dataBarang;
						var dataSatuan = response.result.dataSatuan;
						var dataGudang = response.result.dataGudang;

						$("#dataId").val(dataBarang.idBarang);
						$("#namaBrg").val(dataBarang.namaBarang);

						if (dataBarang.namaKategori != null) {
							var $option = $("<option selected></option>").val(dataBarang.idKategoriBarang).text(dataBarang.namaKategori);
							$('#kategori').append($option).trigger('change');
						}

						if (dataBarang.namaSatuanPengadaan != null) {
							var $option = $("<option selected></option>").val(dataBarang.idSatuanPengadaan).text(dataBarang.namaSatuanPengadaan);
							$('#satuanPengadaan').append($option).trigger('change');
						}

						if (dataBarang.namaSatuanTerkecil != null) {
							var $option = $("<option selected></option>").val(dataBarang.idSatuanTerkecil).text(dataBarang.namaSatuanTerkecil);
							
							$('#satuanTerkecil').append($option).trigger('change');
							$(".satTerkecil").html(dataBarang.namaSatuanTerkecil);
						}
						
						dataSatuan.forEach(function(data) {
							listKonversi.push({ //push into array
								idKonversi: data.id,
								idKonversiSatuan: data.idSatuan,
								jumlahPengadaan: 1,
								konversiSatuan: data.namaSatuan,
								jumlah: data.jumlahKonversi,
								satuanTerkecil: data.namaSatuanTerkecil
							});
						});

						dataGudang.forEach(function(data) {
							listGudang.push({ //push into array 
								unit: data.unit,
								idSatuanRequest: data.idSatuanRequest,
								unitText: data.unitText,
								stokMinimal: parseInt(data.stokMinimal),
								satuanRequest: data.satuanRequest,
								saldoAwal: data.saldoAwal,
								hargaAwal: data.hargaAwal,
								stok: data.estimasiStok
							});
						});

						initTable();
						initTableGudang();
					}
				}
			})
		}
	});
	/*End function edit */
</script>