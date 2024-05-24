<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/select2/js/select2.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalert2.all.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalerts.min.js')?>"></script>

<script>
	//Tampilkan Datatable
    var table;
	function pullData(){
		table = $('#tabel').DataTable({
			"processing": true,
			"serverSide": false,
			"autoWidth": false,
			"responsive": true,
			"bFilter": true,
			"sDom": 'fBtlpi',
			"pagingType": 'numbers',
			"ordering": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Cari Kategori...",
			},
			initComplete: (settings, json) => {
				$('.dataTables_filter').appendTo('#tableSearch');
				$('.dataTables_filter').appendTo('.search-input');
			},
			"order": [],
			"ajax": {
				"url": "<?= site_url('Kategoribarang/getAll') ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [1, 2, 5, 6, 7],
				"orderable": false,
				"visible": false
			}, {
				"className": "text-center",
				"targets": [0, 2, 3, 4, 6],
			}, {
				"className": "text-center",
				"targets": [-1],
				"data": null,
				"defaultContent": '<div class="me-3"><button type="button" class="btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i data-feather="edit" class="text-info" alt="img"></i></button> || <button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i data-feather="trash-2" class="text-danger" alt="img"></i></button></div>'
			}],
			"drawCallback": function(settings){
				feather.replace();
			}
		});

		$('#tabel').on('click', '.btn-edit', function(){
			var data = table.row($(this).parents('tr')).data();
			edit(data[1]);
		});

		$('#tabel').on('click', '.btn-delete', function(){
			var data = table.row($(this).parents('tr')).data();
			remove(data[1]);
		});
	}
    
	//Fungsi Tambah
	function tambah(){
		$('#addkategorimodal').on('shown.bs.modal', function(event){

			//Reset form ketika modal show
			$(this).find('form')[0].reset();
			$('#parent').val(null).trigger('change');
			//$('#status').val(null).trigger('change');

			//Select2 Parent
			$('#parent').select2({
				dropdownParent: $('#addkategorimodal'),
				placeholder: "Pilih Parent",
				disabled: true,
				ajax: {
					url: "<?=site_url('Kategoribarang/select')?>",
					dataType: 'json',
					method: 'get',
					data: function(term, page){
						return{
							q: term, //Search Term
						};
					},
					processResults: function(data){
						return {
							results: $.map(data, function(item){
								return {
									text: item.nama,
									id: item.id
								}
							})
						};
					}
				}
			});

			//Select2 Status
			// $('#status').select2({
			// 	dropdownParent: $('#addkategorimodal'),
			// 	placeholder: "Pilih Status",
			// 	minimumResultsForSearch: -1
			// });
		});

		//Setting Modal
		$('#addkategorimodal').modal({
			backdrop: 'static',
			keyboard: false
		});

		//Tampil Modal
		$('#addkategorimodal').modal('show');

		//Sembunyikan Modal dan Reset Form
		$('#addkategorimodal').on('hidden.bs.modal', function(){
			$(this).find('form')[0].reset();
			$('.form-group').removeClass('was-validated');
		});
	}

	//Fungsi Edit
	function edit(id){
		$.ajax({
			type: "get",
			url: "<?=site_url('Kategoribarang')?>/" + id,
			data: {
				id: id,
			},
			dataType: "json",
			success: function(response){
				if (response.success == true){
					$('#addkategorimodal').on('shown.bs.modal', function(event){
						
						//Display Data di Form
						$('#dataId').val(response.result.idKategoriBarang);
						$('#nama').val(response.result.nama);
						$('#parent').val(response.result.parent);
						$('#createdAt').val(response.result.createdAt);
						$('#createdBy').val(response.result.createdBy);
						//$('#status').val(response.result.status);
						$('#check').prop("checked", response.result.parent != null);
						
						//Select2 Parent
						$('#parent').select2({
							dropdownParent: $('#addkategorimodal'),
							placeholder: "Pilih Parent",
							disabled: response.result.parent == null,
							ajax: {
								url: "<?=site_url('Kategoribarang/select')?>",
								dataType: 'json',
								method: 'get',
								data: function(term, page){
									return{
										q: term, //Search Term
									};
								},
								processResults: function(data){
									return{
										results: $.map(data, function(item){
											return{
												text: item.nama,
												id: item.id
											}
										})
									};
								}
							}
						});

						//select2 status
						// $('#status').select2({
						// 	dropdownParent: $('#addkategorimodal'),
						// 	placeholder: "Pilih Status",
						// 	minimumResultsForSearch: -1
						// });
						 
						if(response.result.parent != null){
							var $option = $("<option selected></option>").val(response.result.parent).text(response.result.namaParent);
							$('#parent').append($option).trigger('change');
						}
					});

					//Setting Modal 
					$('#addkategorimodal').modal({
						backdrop: 'static',
						keyboard: false
					});

					//Tampil Modal
					$('#addkategorimodal').modal('show');

					//Sembunyikan Modal dan Reset Form
					$('#addkategorimodal').on('hidden.bs.modal', function(){
						$(this).find('form')[0].reset();
					});
				}
                else{
					alert("gagal cok");
				}
			},
			error: function(xhr, thrownError){
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			}
		});
	}

	//Fungsi Remove
	function remove(id){
		$.ajax({
			type: "delete",
			url: "<?=base_url('Kategoribarang')?>/" + id,
			dataType: "json",
			success: function(response){
				if (response.success == true){
					Swal.fire({
						title: "Apakah anda yakin?",
                        text: "Data anda akan terhapus",
                        icon: "warning",
                        showCancelButton: !0,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus",
                        cancelButtonText: "Tidak",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-danger ml-1"
                        },
                        heightAuto: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        width: '30em',
                        buttonsStyling: !1,
					}).then((result) => {
                        if (result.isConfirmed){
                            Swal.fire({
                                title: "Data berhasil terhapus",
                                icon: "success",
                                customClass: {
                                    confirmButton: "btn btn-outline-success"
                                },
                                heightAuto: false,
                                width: '30em',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                buttonsStyling: !1
                            }).then(function(){
                                location.reload();
                            })
                        }
                    })
				}
                else{
					alert(response.messages);
				}
			},
			error: function(xhr, thrownError){
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			}
		});
	}
	
	//for pulling data	
	$(document).ready(function(){
		pullData();
	});

	//function batal
	function batal(){
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Inputan anda tidak akan tersimpan",
			icon: "warning",
			showCancelButton: !0,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Batal input",
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
				$('#addkategorimodal').modal('hide');
			}
		})
	}

	function validasiForm(){
		var listValidasi = ['#nama'];
		var isValid = true
		
		listValidasi.forEach(function(nama){
			if($(nama).val() == ""){
				$(nama).closest('.form-group').removeClass("was-validated").addClass("was-validated");	
				isValid = false;
			}
		});

			if($('#check').is(":checked")){
				if($('#parent').val() == null){
					$('#parent').closest('.form-group').removeClass("was-validated").addClass("was-validated");	
					isValid = false;
				}
			}
		
		return isValid;
	}

	//function simpan
	function simpan() {
		var formData = {};
		var dataId = $("#dataId").val();

		$("#formSimpan").serializeArray().map(function(x) {
			formData[x.name] = x.value;
		});

		if(validasiForm() == false){
			Swal.fire({
				title: "Ada form yang belum terisi",
				icon: "warning",
				confirmButtonColor: "#3085d6",
				confirmButtonText: "Ok"
			})
			return;
		}
		else{
			Swal.fire({
				title: "Apakah anda ingin menyimpan?",
				icon:"question",
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
				buttonsStyling: !1,
			}).then((result) => {
				if(result.isConfirmed){
					var xData = JSON.stringify (formData);
					$.ajax({
						type: "POST",
						url: "<?= base_url ("Kategoribarang")?>",
						data: {
							id: dataId,
							konten: xData
						},
						dataType: "json",
						success: function(response){
							if(response.isSuccess == true) {
								Swal.fire({
									title: "Data berhasil tersimpan",
									icon: "success",
									customClass:{
										confirmButton: "btn btn-outline-success"
									},
									heightAuto: false,
									width: '30em',
									allowOutsideClick: false,
									allowEscapeKey: false,
									buttonsStyling: !1
								}).then(function(){
									$('#addkategorimodal').modal('hide');
									location.reload();
								});
							}else{
								alert("Gagal cuk" + response.message);
							}
						},
						error: function(xhr, thrownError) {
							alert(xhr.status + "\n" +xhr.responseText + "\n" +thrownError);
						},
					});
				}
			})
		} 
	}

	//checkbox parent
	$(".form-check-input").on("click", function() {
		if (this.checked){
			$("#parent").prop("disabled", false);
		} 
		else {
			$("#parent").prop("disabled", true);
			$('#parent').val(null).trigger('change');
		}
	});
</script>