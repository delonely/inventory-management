<script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalerts.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>

<script>

	//for collapse button header
	$('#dataNota').click(function() {
		$(this).text(function(i, old) {
			return old == '- Data Nota' ? '+  Data Nota' : '- Data Nota';
		});
	});

	$('#dataBarang').click(function() {
		$(this).text(function(i, old) {
			return old == '- Data Barang' ? '+ Data Barang' : '- Data Barang';
		});
	});
	//end collapse button header

	//fungsi cari supplier
	var selectedSupplier = '';

	function cariSupp() {
		$('#carisuppliermodal').show();
		$('#carisuppliermodal').on('shown.bs.modal', function(event) {
			var tableSupp;
			var tableBody = '#tabelSupp tbody';

			tableSupp = $('#tabelSupp').DataTable({
				"select": true,
				"defaultContent": '',
				"processing": true,
				"serverSide": true,
				"autoWidth": true,	
				"responsive": true,
				"bFilter": true,
				"retrieve": true,
				"sDom": 'ftlp',
				'pagingType': 'numbers',
				"ordering": true,
				"language": {
					search: ' ',
					sLengthMenu: '_MENU_',
					searchPlaceholder: "Cari Nama Supplier...",
				},
				initComplete: (settings, json) => {
					$('.dataTables_filter').appendTo('#tableSearch');
					$('.dataTables_filter').appendTo('.search-input');
				},
				"order": [],
				"ajax": {
					"url": "<?= site_url('Supplier/getAll') ?>",
					"type": "POST"
				},
				"columnDefs": [{
					"targets": [1, 6],
					"orderable": false,
					"visible": true,
				}]
			});

			tableSupp.on('select', function(e, dt, type, indexes) {
				var data = tableSupp.rows({selected: true}).data()[0];

				if(data !== undefined){
					selectedSupplier = [data[1], data[2], data[3], data[4], data[5]];
					console.log(data);
				}
			});
		});

		$('#carisuppliermodal').modal({
			backdrop: 'static',
			keyboard: false
		});

		$('#carisuppliermodal').modal('show');
	}
	//end fungsi cari supplier

	//fungsi tambah supp
	function tambahSupp() {
		$('#carisuppliermodal').modal('hide');
		$('#namaSupplier').val(selectedSupplier[1]);
		$('#kategoriSupp').val(selectedSupplier[2]);
		$('#alamatSupp').val(selectedSupplier[3]);
		$('#telpSupp').val(selectedSupplier[4]);
	}
	//end fungsi tambah supp

	//fungsi cari data pajak
	var selectedPajak = '';

	function cariPajak() {
		$('#caripajakmodal').show();
		$('#caripajakmodal').on('shown.bs.modal', function(event) {
			var tabelPajak;
			var tableBody = '#tabelPajak tbody';

			tabelPajak = $('#tabelPajak').DataTable({
				"select": true,
				"defaultContent": '',
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"responsive": true,
				"bFilter": true,
				"retrieve": true,
				"sDom": 'ftlp',
				'pagingType': 'numbers',
				"ordering": true,
				"language": {
					search: ' ',
					sLengthMenu: '_MENU_',
					searchPlaceholder: "Cari Nama Pajak...",
				},
				initComplete: (settings, json) => {
					$('.dataTables_filter').appendTo('#tableSearch');
					$('.dataTables_filter').appendTo('.search-input');
				},
				"order": [],
				"ajax": {
					"url": "<?= site_url('Pajak/getAll') ?>",
					"type": "POST"
				},
				"columnDefs": [{
					"targets": [0, 1, 4, 5],
					"orderable": false,
					"visible": false,
				},{
					"className": "text-center",
					"targets": [2, 3]
				}],
			});

			tabelPajak.on('select', function(e, dt, type, indexes) {
				var data = tabelPajak.rows({selected: true}).data()[0];

				if(data !== undefined){
					selectedPajak = [data[1], data[2], data[3]];
					console.log(data);
				}
			});
		});

		$('#caripajakmodal').modal({
			backdrop: 'static',
			keyboard: false
		});

		$('#caripajakmodal').modal('show');
	}
	//end fungsi cari data pajak

	//fungsi tambah pajak
	function tambahPajak() {
		$('#caripajakmodal').modal('hide');
		$('#namaPajak').val(selectedPajak[1]);
		$('#persen').val(selectedPajak[2]);
		kalkulasiTotalHarga();
	}
	//end fungsi tambah pajak

	//fungsi cari data barang
	var selectedBarang = '';

	function cariBarang() {
		$('#caribarangmodal').show();
		$('#caribarangmodal').on('shown.bs.modal', function(event) {

			var tableBarang;
			var tableBody = '#tabelBarang tbody';
			//$('#tabel').DataTable().clear().destroy();
			tableBarang = $('#tabelBarang').DataTable({
				"select": true,
				"defaultContent": '',
				"processing": true,
				"serverSide": true,
				"autoWidth": false,
				"responsive": true,
				"bFilter": true,
				"destroy": true,
				"sDom": 'ftlp',
				'pagingType': 'numbers',
				"ordering": true,
				"language": {
					search: ' ',
					sLengthMenu: '_MENU_',
					searchPlaceholder: "Cari Nama Barang...",
				},
				initComplete: (settings, json) => {
					$('.dataTables_filter').appendTo('#tableSearch');
					$('.dataTables_filter').appendTo('.search-input');
				},
				"order": [],
				"ajax": {
					"url": "<?= site_url('Databarang/getMine') ?>",
					"type": "POST"
				},
				"columnDefs": [{
					"targets": [ 1, 2 , 5, 6, 7 , 10],
					"orderable": false,
					"visible": true,
				}],
			});

			tableBarang.on('select', function(e, dt, type, indexes) {
				var data = tableBarang.rows({selected: true}).data()[0];

				if(data !== undefined){
					selectedBarang = [data[1], data[4], data[6], data[8]];
					console.log(data);
				}
			});
		});

		$('#caribarangmodal').modal({
			backdrop: 'static',
			keyboard: false
		});

		$('#caribarangmodal').modal('show');
	}
	//end fungsi cari data barang

	//fungsi tambah data barang
	function okCari() {
		$('#caribarangmodal').modal('hide');
		$('#namaBrg').val(selectedBarang[1]);
		$('#satuanBrg').val(selectedBarang[3]);

		document.getElementById("satuanBrg").disabled = false;
		document.getElementById("jumlah").disabled = false;
		document.getElementById("hargaSat").disabled = false;

		$('.satuan').select2({
			// placeholder: "Pilih Satuan",
			// disabled: false,
			ajax: {
				url: "<?= site_url('Satuanbarang/terkecil/') ?>/" + selectedBarang[0],
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

		// if(selectedBarang[2] != null){
		// 	var $option = $("<option selected></option>").val(selectedBarang[2]).text(selectedBarang[3]);
		
		// 	$('#satuanBrg').append($option).trigger('change');
		// }

		//$("#jumlah").focus();
	}
	//end fungsi tambah data barang

	/**
	 * enabling tambah button when jumlah dan satuan terisi
	 */
	// var enableTambahButton = ($('#satuanBrg, #jumlah, #hargaSat').val() != null) ? console.log("nyala hore") : console.log('gagal nyala');
	/**\ end enabling var */

	//destroy select2
	if ($('.satuan').hasClass("select2-hidden-accessible")) {
		$('.satuan').select2("destroy");
	}
	$('.satuan').select2();
	//end destroy select2

	//fungsi batal cari
	function batalCari() {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Anda akan keluar",
			icon: "warning",
			showCancelButton: !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, batal cari",
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
				selectedBarang = '';
				$('#carisuppliermodal').modal('hide');
				$('#caribarangmodal').modal('hide');
				$('#caripajakmodal').modal('hide');
			}
		})
	}
	//end fungsi batal cari

	//fungsi hitung total
	$('#jumlah, #hargaSat').change(function() {
		var jmlBrg = parseFloat($('#jumlah').val()) || 0;
		var hargaSat = parseFloat($('#hargaSat').val()) || 0;

		$('#total').val(jmlBrg * hargaSat);
	});
	//end fungsi hitung total

	var listBrg = [];
	var tabelBrg = null;

	//fungsi tambah data barang
	function tambahBrg() {
		jmlBrg = document.getElementById('jumlah').value;
		idBarang = selectedBarang[0];
		namaBrg = document.getElementById('namaBrg').value;
		idSatuan = $("#satuanBrg option:selected").val();
		satuan = $("#satuanBrg option:selected").text();
		hargaSat = document.getElementById('hargaSat').value;
		totalHarga = $("#total").val();


		var found = -1;

		for (var arr in listBrg) {
			if (listBrg[arr]['idBarang'] == idBarang && listBrg[arr]['idSatuanBarang'] == idSatuan) {
				found = arr;
				break;
			}
		}

		if (found >= 0) {
			listBrg[found]['jumlah'] = parseInt(listBrg[found]['jumlah']) + parseInt(jmlBrg);
			listBrg[found]['hargaSat'] = parseInt(listBrg[found]['hargaSat']) + parseInt(hargaSat);
		} else {
			listBrg.push({
				jumlah: jmlBrg,
				idBarang: idBarang,
				nama: namaBrg,
				idSatuanBarang: idSatuan,
				satuan: satuan,
				hargaSatuan: hargaSat,
				totalHarga: totalHarga
			});
		}
		kalkulasiTotalHarga();
		console.log(listBrg);
		initTable();

		const formInput = document.querySelectorAll('#namaBrg, #satuanBrg, #jumlah, #hargaSat, #total');

		formInput.forEach(input => {
			input.value = '';
		});

		selectedBarang = '';
		$('.satuan').val(null).trigger('change');

		var enableSimpan = ($('#tabelPembelian').val() != null) ? document.getElementById("simpanPurchase").disabled = false : document.getElementById("simpanPurchase").disabled = true;
	}
	//end fungsi tambah data barang

	//fungsi init tabel pembelian
	function initTable() {
		tabelBrg = $('#tabelPembelian').DataTable({
			"processing": true,
			"serverSide": false,
			"autoWidth": false,
			"responsive": true,
			"bfilter": true,
			"sDom": 'ftlp',
			"paging": false,
			"scrollY": '200px',
			"scrollCollapse": true,
			"ordering": false,
			"aaData": listBrg,
			"aoColumns": [{
					"data": "nama"
				}, {
					"data": "jumlah"
				}, {
					"data": "satuan"
				}, {
					"data": "hargaSatuan",
					"render": $.fn.dataTable.render.number( ',', '.', 2 , 'Rp. ')
				}, {
					"data": "totalHarga",
					"render": $.fn.dataTable.render.number( ',', '.', 2, 'Rp. ' )
				}],
			"columnDefs": [{
				"className": "text-center",
				"targets": [0, 1, 2, 3, 4],
			}, {
				"className": "text-center",
				"targets": [5],
				"data": null,
				"defaultContent": '<button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><img src="<?= base_url('assets/img/icons/delete.svg') ?>" alt="img"></button></div>'
			}],
			"bDestroy": true
		});

		$('#tabelPembelian').on('click', '.btn-delete', function() {
			var data = tabelBrg.row($(this).parents('tr')).data();
			if (data == null) return;
			var found = 0;
			for (let i = 0; i < listBrg.length; i++) {
				if (listBrg[i]['idSatuanBarang'] == data['idSatuanBarang']) {

					listBrg.splice(i, 1);
					tabelBrg
						.row($(this).parents('tr'))
						.remove()
						.draw();
					$('#tabelPembelian').dataTable().fnDeleteRow(data['idSatuanBarang']);
					kalkulasiTotalHarga();
				}
			};
		});
	}
	//end fungsi tabel pembelian

	//start fungsi kalkulasi total harga
	function kalkulasiTotalHarga(){
		var sebelumPajak = 0;
		var harga = <?=$limitPajak?>;
		var nilaiPersen = $("#persen").val().trim()=="" ? 0 : parseFloat($("#persen").val());

		listBrg.forEach((item)=>{
			sebelumPajak += parseFloat(item.totalHarga);
		});
		
		$("#sebepa").html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(sebelumPajak));
		
		if(sebelumPajak >= harga){
			//console.log("ayo itung pajak");
			$('#pajak').html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(sebelumPajak * (nilaiPersen) / 100));
			$('#sesupa').html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(sebelumPajak * (100 + nilaiPersen) / 100));
		}else{
			$("#pajak").html("0");
			$('#sesupa').html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(sebelumPajak));
		}
	}
	//end kalkulasi total harga

	function simpanPembelian(){ 			 
		var formData = {};
		var dataId = $("#dataId").val();

		$("#formSupplier").serializeArray().map(function(x) {
			formData[x.name] = x.value;
		});

		 formData['detailData']=listBrg;

		$("#formPembelian").serializeArray().map(function(x) {
			formData[x.name] = x.value;
		});

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
			})
			.then((result) => {
				if (result.isConfirmed){
					var xData = JSON.stringify(formData);
					var idpajak = selectedPajak == '' ? 1 : selectedPajak[0];
					var supplier = selectedSupplier == '' ? 1 : selectedSupplier[0];
					var idSatuanBrg = selectedBarang == '' ? 1 : selectedSupplier[2];
					//var noNota = $('input[name=noNota]').val();
					var noNota = $('#noNota').val();
					var date = $('input[name=tglNota]').val().split('-');
					var tglNota = date[2] + '-' + date[1] + '-' + date[0];

					$.ajax({
						type: "POST",
						url: "<?=base_url("Purchase")?>",
						data: {
							id: dataId,
							idPajak: idpajak,
							supplier: supplier,
							konten: xData,
							nomorNota: noNota,
							tanggalNota: tglNota,
							idSatuanBarang: idSatuanBrg
						},
						dataType: "json",
						success: function(response){
							console.log(response);
							if(response.isSuccess == true){
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
								}).then(function() {
									window.history.back();
								});
							}
							else if(result.isDenied){
								Swal.fire({
									title: "Data Gagal Tersimpan",
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

	//ganti format date YYYY-MM-DD
	// $('#datetimepicker2').datetimepicker( {
	// 	// maxDate: moment(),
	// 	// allowInputToggle: true,
	// 	// enabledHours : false,
	// 	//  locale: moment().local('en'),
	// 	//format: 'YYYY-MM-DD'
	// 	//pickTime: false,
	// 	format: 'DD-MM-YYYY'
	// });
	//end ganti format date YYYY-MM-DD

	// $(document).ready(function(){
        
	// 	var path = window.location.pathname.toString();
	// 	var paths = path.split("/");

	// 	if (paths.length == 5) {
	// 		// alert(paths[4]);
	// 		$.ajax({
	// 			type: "get",
	// 			url: "<?= site_url('Purchase/') ?>" + paths[4],

	// 			dataType: "json",
	// 			success: function(response) {
	// 				if (response.success == true) {

	// 					var mainData = response.result.mainData;
						
	// 					detailData = response.result.detailData;

						
	// 					$("#dataId").val(detailData.idBarang);

	// 					detailData.forEach(function(data) {
	// 						listBrg.push({
	// 							idPajak: data.idPajak,
	// 							idBarang: data.idBarang,
	// 							idSatuanBarang: data.idSatuanBarang,
	// 							nama: data.namaBarang,
	// 							satuan: data.namaSatuan,
	// 							jumlah: data.jumlah,
	// 							hargaSatuan: data.hargaSatuan,
	// 							totalHarga: data.totalHarga
	// 						});
	// 					});
	// 			// 		jumlah: jmlBrg,
	// 			// idBarang: idBarang,
	// 			// nama: namaBrg,
	// 			// idSatuanBarang: idSatuan,
	// 			// satuan: satuan,
	// 			// hargaSatuan: hargaSat,
	// 			// totalHarga: totalHarga
	// 					initTable();
	// 					console.log(response.result.mainData);
	// 					var mData = response.result.mainData;
	// 					$("#noNota").val(mData.noNota);
	// 					$("#datetimepicker2").val(mData.tanggalNota);
	// 				}
	// 			}
	// 		});
	// 	}
    // });
</script>