<script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalerts.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.js') ?>"></script>

<script>
	var selectedBarang = '';
	$('#client').select2({
        placeholder: "Pilih Unit",
        disabled: false,
        ajax: {
            url: "<?= site_url('Unit/client') ?>",
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

	function cari(){
		$('#carimodal').show();
		$('#carimodal').on('shown.bs.modal', function(event) {
			
			var tableBarang;
			var tableBody = '#tableBarang tbody';
			//$('#tabel').DataTable().clear().destroy();
			tableBarang= $('#tableBarang').DataTable({
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
					"url": "<?=site_url('Databarang/getMine')?>",
					"type": "POST"
				},
				"columnDefs": [{
					"targets": [1, 2, 6, 7, 10],
					"orderable": false,
					"visible": true,
				}],
			});		

			tableBarang.on( 'select', function ( e, dt, type, indexes ) {
				var data = tableBarang.rows({selected: true}).data()[0];

				if(data !== undefined){
					selectedBarang=[data[1], data[4], data[5]];
					console.log(data);
				}
			});
		});
	
		$('#carimodal').modal({
			backdrop : 'static',
			keyboard : false
		});

		$('#carimodal').modal('show');
	}


	/**
	 * function kurang stok di text field
	 */
	$('#stokBrg, #jumlah, #satuanBrg').change(function(){
		var stokBrg =  parseFloat(selectedBarang[2]);
		var jmlBrg = parseFloat($('#jumlah').val()) * jumlahKonversi || 0;
		
		
		 if(jmlBrg > stokBrg) {
			$('#stokBrg').val(stokBrg-jmlBrg);
			document.getElementById("tambah").disabled = true;

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
			toastr["error"]("Stok Minus: Jumlah Barang Tidak Boleh Melebihi Jumlah Stok")
			return;
		}else if(jmlBrg <= stokBrg){
			$('#stokBrg').val(stokBrg-jmlBrg);
			document.getElementById("tambah").disabled = false;
		}
	});
	/**\ end function kurang stok */
	var jumlahKonversi = 0;
	function okCari(){
		$('#carimodal').modal('hide');
		$('#cariBrg').val(selectedBarang[1]);
		$('#stokBrg').val(selectedBarang[2]);
		
		document.getElementById("satuanBrg").disabled = false;
		document.getElementById("jumlah").disabled = false;
		
		$('.satuan').select2({
			placeholder: "Pilih Satuan",
			disabled: false,
			ajax: {
				url: "<?=site_url('Satuanbarang/terkecil/')?>/" + selectedBarang[0] ,
				dataType: 'json',
				method: 'get',
				data: function(term, page){
					return{
						q: term
					};
				},
				processResults: function(data){
					return{
						results: $.map(data, function(item){
							return{
								text: item.nama,
								id: item.id, "data-konversi": item.jumlahKonversi
							}
						})
					};
				}
			}
		}).on('select2:select', function(e){
			var data = e.params.data;
			$('#jumlah').val(0);
			jumlahKonversi = parseInt(data["data-konversi"]);
			console.log(data["data-konversi"]);
			// $(this).children('[value="'+data['id']+'"]').attr(
			// 	{
			// 		'data-konversi':data["data-konversi"],
			// 		'key':'val'
			// 	}
			// );
		});
	}
	
	
    function batalCari(){
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Anda akan keluar",
			icon: "warning",
			showCancelButton : !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, batal cari",
			cancelButtonText: "Tidak",
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-danger ml-1"
			},
			heightAuto:false,
			allowOutsideClick:false,
			allowEscapeKey:false,
			width: '30em',
			buttonsStyling: !1
		}).then ((result) =>{
			if (result.isConfirmed){
				selectedBarang='';
				$('#carimodal').modal('hide');
			}
		})
	}

	// $('#client').on('select2:select', function(e) {
	// 	var data = e.params.data;
	// 	//#Perlu ada konfirmasi apakah mau ganti client
	// 	listBrg = [];
	// 	initTable();
	// });
	var listBrg = [];
	var tabelBrg;

	function tambahBrg(){

		jmlBrg = document.getElementById('jumlah').value;
		idBarang = selectedBarang[0];//document.getElementById('cariBrg').value;
		namaBrg = document.getElementById('cariBrg').value;
		idSatuan = $("#satuanBrg option:selected").val(); 
		satuan = $("#satuanBrg option:selected").text();
		
		var found = -1;
		 
		for(var arr in listBrg){ //check if there is a data with same value
			if(listBrg[arr]['idBarang'] == idBarang && listBrg[arr]['idSatuanBarang'] == idSatuan){
				found = arr;
				break;
			} 
		} 

		if(found >= 0){ //if there is data with same value, 
			listBrg[found]['jumlah']=parseInt(listBrg[found]['jumlah']) + parseInt(jmlBrg);
		} else {
			listBrg.push({ //push into array
				jumlah: jmlBrg,
				idBarang: idBarang,
				nama: namaBrg,
				idSatuanBarang: idSatuan,
				satuan: satuan
			});
		}

		initTable();
		
		const formInput = document.querySelectorAll('#cariBrg, #satuanBrg, #jumlah, #stokBrg');

		formInput.forEach(input => {
			input.value = '';
		});

		selectedBarang = '';
		$('.satuan').val(null).trigger('change');
		
		var enableSimpan = ($('#tabelPermintaan').val() != null) ? document.getElementById("simpanPermintaan").disabled = false : document.getElementById("simpanPermintaan").disabled = true;
	}

	function initTable(){
		tabelBrg = $('#tabelPermintaan').DataTable({
			"processing": true,
			"serverSide": false,
			"autoWidth": false,
			"responsive": true,
			"bfilter": true,
			"sDom": 'ftlpi',
			"pagingType": 'numbers',
			"ordering": true,
			"aaData": listBrg,
			"aoColumns": [{
				"data": "nama"
			},{
				"data": "jumlah"
			},{
				"data": "satuan"
			}],
			"columnDefs": [{
				"className": "text-center",
				"targets": [3],
				"data": null,
				"defaultContent": '<button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><img src="<?= base_url('assets/img/icons/delete.svg') ?>" alt="img"></button></div>'
			}],
			"bDestroy": true
		});	

		$('#tabelPermintaan').on('click', '.btn-delete', function(){
			var data = tabelBrg.row($(this).parents('tr')).data();
			if(data == null) return;
			var found=0;
			for(let i = 0; i < listBrg.length; i++){
				if(listBrg[i]['idSatuanBarang'] == data['idSatuanBarang']){
					listBrg.splice(i, 1);
					tabelBrg
						.row($(this).parents('tr'))
						.remove()
						.draw();
					$('#tabelPermintaan').dataTable().fnDeleteRow(data['idSatuanBarang']);
				}
			};
		});			
	}

	function simpanPermintaan(){

		var formData = {};
		var dataId = $("#dataId").val();

		$("#formPermintaan").serializeArray().map(function(x){ //make an array
			formData[x.name] = x.value;
		});

		formData['detailData'] = listBrg;

		formData['userRequest'] = $("#client").val();

		console.log(formData);
	
		Swal.fire({
			title: "Apakah anda ingin menyimpan?",
			icon: "question",
			showCancelButton : !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Simpan",
			cancelButtonText: "Tidak",
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-danger ml-1"
			},
			heightAuto:false,
			width: '30em',
			allowOutsideClick:false,
			allowEscapeKey:false,
			buttonsStyling: !1
		}) 
		.then((result) => {
				if(result.isConfirmed){
					var xData = JSON.stringify(formData);
					var date = $('input[name=tglPermintaan]').val().split('-');
					var tglPermintaan = date[2] + '-' + date[1] + '-' + date[0];

					$.ajax({
						type: "POST",
						url: "<?=base_url("Permintaanbarang")?>",
						data: {
							id: dataId,
							konten: xData,
							tanggal: tglPermintaan
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
								})
								.then(function(){
									window.history.back();
								});
							}
							else {
								Swal.fire({
									title: response.message,
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

	function batalPermintaan(){
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Inputan anda tidak akan tersimpan",
			icon: "warning",
			showCancelButton : !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Batal input",
			cancelButtonText: "Tidak",
			customClass: {
				confirmButton: "btn btn-primary",
				cancelButton: "btn btn-danger ml-1"
			},
			heightAuto:false,
			allowOutsideClick:false,
			allowEscapeKey:false,
			width: '30em',
			buttonsStyling: !1
		}).then ((result) =>{
			if (result.isConfirmed){
				history.back();
			}
		})
	}

	if($('.satuan').hasClass("select2-hidden-accessible")){
		$('.satuan').select2("destroy");
	}
	$('.satuan').select2();

	$('#datetimepicker2').datetimepicker( {
		// maxDate: moment(),
		// allowInputToggle: true,
		// enabledHours : false,
		//  locale: moment().local('en'),
		//format: 'YYYY-MM-DD'
		//pickTime: false,
		format: 'DD-MM-YYYY'
	});
</script>