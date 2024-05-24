<script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalerts.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<!-- <script src="<?= base_url('assets/js/select.dataTables.min.js') ?>"></script> -->
<script src="<?= base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>


<script>
	
    var table;
	/**Tampilkan data di tabel */
	function pullData() { 
		table = $('#tabel').DataTable({
			"processing": true,
			"serverSide": true,
			"autoWidth" : false,
			"responsive": true,
			"bFilter"   : true,
			"sDom"      : 'fBtlpi',  
			'pagingType': 'numbers', 
			"ordering"  : true,
			"language"  : {
						search: ' ',
						sLengthMenu: '_MENU_',
						searchPlaceholder: "Cari Nama User...",
						},
				initComplete: (settings, json)=>{
				$('.dataTables_filter').appendTo('#tableSearch');
				$('.dataTables_filter').appendTo('.search-input');
			},
			"order"   : [],
			"ajax"    : {
				"url" : "<?= site_url('User/getAll') ?>", 
				"type": "POST"
			},
			"columnDefs": [{ //for hiding column
				"targets": [1, 2, 8],
				"orderable": false,
				"visible": false
			},{
                "className": "text-center",
                "targets": [3, 4, 5, 6, 7],   
            },{
				"className": "text-center", //for calling edit and delete button
				"targets": [-1],
				"data": null,
				"defaultContent": '<div class="me-3"><button type="button" class="btn btn-users" data-bs-toogle="tooltip" title="Mutasi"><i data-feather="users" class="text-success"></i></button> || <button type="button" class="btn btn-edit"><i data-feather="edit" class="text-info"></i></button> || <button type="button" class="btn btn-delete"><i data-feather="trash-2" class="text-danger"></i></button></div>',
			}],
			"drawCallback": function(settings){
					feather.replace();
				}
		});

		$('#tabel').on('click', '.btn-edit', function(){
			var data = table.row($(this).parents('tr')).data();
			edit(data[1]);
		})

		$('#tabel').on('click', '.btn-users', function(){
			var data = table.row($(this).parents('tr')).data();
			mutasiUser(data[1]);
		})

		$('#tabel').on('click', '.btn-delete', function(){
			var data = table.row($(this).parents('tr')).data();
			remove(data[1]);
		});
	}

    $(document).ready(function(){
        pullData();
    });

	function mutasiUser(id){
		$.ajax({
			type: "get",
			url: "<?=site_url('User')?>/" + id,
			data: {
				id: id,
			},
			dataType: 'json',
			success: function(response){
				if(response.success == true){
					$('#mutasimodal').on('shown.bs.modal', function(event){
						$('#dataId').val(response.result.idUser);
						$('#namaUser').val(response.result.namaUser);

						$('#idUnit').select2({
							dropdownParent: $('#mutasimodal'),
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
					});

					$('#mutasimodal').modal({
						backdrop: 'static',
						keyboard: false
					});

					$('#mutasimodal').modal('show');

					$('#mutasimodal').on('hidden.bs.modal', function(){
						$(this).find('form')[0].reset();
					});
				}else{
					alert("adudu");
				}
			},	
			error: function(xhr, thrownError){
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			}
		});
	}

	function simpanMutasi() {
		var formData = {};
		var dataId = $("#dataId").val();
			
		$("#formMutasi").serializeArray().map(function(x) {
			if(x.name == 'tglMutasi'){
				var date = $('input[name=tglMutasi]').val().split('-');
					var tgl = date[2] + '-' + date[1] + '-' + date[0];
					formData[x.name] = tgl;
			}else {
			formData[x.name] = x.value;
			}
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
		}).then((result) => {
			if (result.isConfirmed) {
				
				var xData = JSON.stringify(formData);
				
				$.ajax({
					type: "POST",
					url: "<?=site_url('User')?>/" + dataId,
					data: {
						id: dataId,
						konten: xData,
					},
					dataType: "json",
					success: function(response) {
					 
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
							}).then(function() {
								location.reload();
							});
						} else if (result.isDenied) {
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

	function edit(id){
		$.ajax({
			type: "get",
			url: "<?=site_url('User')?>/" + id,
			data: {
				id: id,
			},
			dataType: 'json',
			success: function(response){
				if(response.success == true){
					$('#editusermodal').on('shown.bs.modal', function(event){
						
						$('#dataIdEdit').val(response.result.idUser);
						$('#namaUserEdit').val(response.result.namaUser);
						$('#usernameEdit').val(response.result.username);

						$('#roleEdit').select2({
							dropdownParent: $('#editusermodal'),
							placeholder: "Pilih Role",
							disabled: false,
							ajax: {
								url: "<?= site_url('Role/select') ?>",
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
												id: item.id
											}
										})
									};
								}
							}
						});

						if(response.result.idRole != null){
							var $option = $("<option selected></option>").val(response.result.idRole).text(response.result.namaRole);
							$('#roleEdit').append($option).trigger('change');
						}
					});

					$('#editusermodal').modal({
						backdrop: 'static',
						keyboard: false
					});

					$('#editusermodal').modal('show');

					$('#editusermodal').on('hidden.bs.modal', function(){
						$(this).find('form')[0].reset();
					});
				}else{
					alert("adudu");
				}
			},	
			error: function(xhr, thrownError){
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			}
		});
	}

	function batal(){
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
				$('#editusermodal').modal('hide');
				$('#mutasimodal').modal('hide');
			}
		})
	}

	function simpanEdit() {
		var formData = {};
		var dataId = $("#dataIdEdit").val();
		formData['namaUser']=$("#namaUserEdit").val();
		formData['username']=$("#usernameEdit").val();
		formData['password']=$("#passwordEdit").val();
		formData['role']=$("#roleEdit").val();
	
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
					url: "<?= base_url ("User")?>",
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

	//Fungsi Remove
	function remove(id){
		$.ajax({
			type: "delete",
			url: "<?=base_url('User')?>/" + id,
			dataType: "json",
			success: function(response){
				if (response.success == true){
					console.log(response);
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
</script>

