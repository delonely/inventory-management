<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/select2/js/select2.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalert2.all.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalerts.min.js')?>"></script>

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
						searchPlaceholder: "Cari Data Pajak...",
						},
				initComplete: (settings, json)=>{
				$('.dataTables_filter').appendTo('#tableSearch');
				$('.dataTables_filter').appendTo('.search-input');
			},
			"order"   : [],
			"ajax"    : {
				"url" : "<?= site_url('Pajak/getAll') ?>", 
				"type": "POST"
			},
			"columnDefs"   : [{
				"targets"  : [1, 5],
				"visible": false,
			}, {
                "className": "text-center",
                "targets": [-1],
                "data": null,
                "defaultContent": '<div class="me-3"><button type="button" class="btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i data-feather="edit" class="text-info" alt="img"></i></button> || <button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i data-feather="trash-2" class="text-danger" alt="img"></i></button></div>'
            },{
                "className" : "text-center",
                // "targets"   : [0, 1, 3, 4, 5, 6, 7],   
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

	function tambah(){
		$('#addpajakmodal').on('shown.bs.modal', function(event){
			//Reset form ketika modal show
			$(this).find('form')[0].reset(); 
			$('#nama').focus();
		});

		//Setting Modal
		$('#addpajakmodal').modal({
			backdrop: 'static',
			keyboard: false
		});

		//Tampil Modal
		$('#addpajakmodal').modal('show');

		//Sembunyikan Modal dan Reset Form
		$('#addpajakmodal').on('hidden.bs.modal', function(){
			$(this).find('form')[0].reset();
			$('.form-group').removeClass('was-validated');
		});
	}

	function edit(id){
        $.ajax({
            type    : "get",
            url     : "<?= site_url('Pajak') ?>/" +id,
            data    : {
                id  : id,
            },
            dataType: "json",
            success : function(response){
                if (response.success == true){
                    $('#addpajakmodal').on('shown.bs.modal', function(event){
                        
                        $('#dataId').val(response.result.id);
                        $('#nama').val(response.result.nama);
						$('#persen').val(response.result.persen);
						$('#keterangan').val(response.result.notes); 
						$('#nama').focus();	
                         
                    });
                    $('#addpajakmodal').modal({
                        backdrop    : 'static',
                        keyboard    : false
                    });
                    $('#addpajakmodal').modal('show');
                    $('#addpajakmodal').on('hidden.bs.modal', function(){
                      $(this).find('form')[0].reset();  
                    });
                } else{
                    alert("gagal lah");
                }
            },
            error   : function(xhr, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" +thrownError);
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
				$('#addpajakmodal').modal('hide');
			}
		})
	}

	function validasiForm(){
		var listValidasi = ['#nama','#persen'];
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
						url: "<?= base_url ("Pajak")?>",
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
	}

	function remove(id){
        $.ajax({
            type    : "delete",
            url     : "<?= site_url('Pajak')?>/"+ id, 
            dataType: "json",
            success : function(response){
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

    $(document).ready(function(){
        pullData();
    });

	

</script>

