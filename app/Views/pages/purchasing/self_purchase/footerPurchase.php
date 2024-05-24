<script src="<?=base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/datetime.js') ?>"></script>
<script src="<?=base_url('assets/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/select2/js/select2.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalert2.all.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalerts.min.js')?>"></script>

<script>
	moment.updateLocale(moment.locale(), { invalidDate: "Tidak ada tanggal" });
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
						searchPlaceholder: "Cari Nomor Nota...",
						},
				initComplete: (settings, json)=>{
				$('.dataTables_filter').appendTo('#tableSearch');
				$('.dataTables_filter').appendTo('.search-input');
			},
			"order"   : [],
			"ajax"    : {
				"url" : "<?= site_url('Purchase/getAll') ?>", 
				"type": "POST"
			},
			"columnDefs"   : [{
				"targets"  : [0],
				"orderable": false,
				"width": "10%"
			},{
                "className" : "text-center",
                "targets"   : [0, 1, 2, 3, 4, 5, 6, 7, 8 , 9],   
            },{
				"targets": [1, 6, 8, 9 ],
				"orderable": false,
				"visible": false
			},{
				"className": "text-center", //for calling edit and delete button
				"targets": [-1],
				"data": null,
				"defaultContent": '<div class="me-3"><button type="button" class="btn btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i data-feather="edit" class="text-info" alt="img"></i></button> || <button type="button" class="btn btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i data-feather="trash-2" class="text-danger" alt="img"></i></button></div>'
			},{
				"targets": [2, 4, 6],
				"orderable": false,
				"width": "20%"
			},{
				"targets": [7],
				"render": $.fn.dataTable.render.moment('DD-MM-YYYY')
			},{
				"targets": [5],
				"render": $.fn.dataTable.render.number( ',', '.', 2 , 'Rp. ')
			}],
			"drawCallback": function(settings){
				feather.replace();
			}
		});

		$('#tabel').on('click', '.btn-edit', function() {
				var data = table.row($(this).parents('tr')).data();
				edit(data[1]);
		});

		$('#tabel').on('click', '.btn-delete', function(){
			var data = table.row($(this).parents('tr')).data();
			remove(data[1]);
		});
		
	}

	//Fungsi Remove
	function remove(id){
		$.ajax({
			type: "delete",
			url: "<?=base_url('Purchase')?>/" + id,
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

    $(document).ready(function(){
        pullData();
    });

	
</script>

