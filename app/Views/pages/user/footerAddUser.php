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
	$('#unit').select2({
		placeholder: "Pilih Unit",
		disabled: false,
		ajax: {
			url: "<?= site_url('Unit/select') ?>",
			dataType: 'json',
			method: 'get',
			data: function(term, page) {
				return{
					q: term, //Search Term
				};
			},
			processResults: function(data){
				return {
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

	$('#role').select2({
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

	function simpanUser() {
		var formData = {};
		var dataId = $("#dataId").val();

		$("#formUser").serializeArray().map(function(x) {
			if(x.name == 'tgl'){
				var date = $('input[name=tgl]').val().split('-');
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
					url: "<?= base_url("User") ?>",
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
								window.history.back();
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

	function batalUser(){
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
				window.history.back();
			}
		})
	}

	$(document).ready(function(){
		var path = window.location.pathname.toString();
		var paths = path.split("/");

		if(paths.length == 5){
			$.ajax({
				type: "get",
				url: "<?=site_url('User/')?>" + paths[4],
				dataType: "json",
				success: function(response){
					if(response.success == true){
						var editUser = response.result;

						$("#dataId").val(editUser.idUser);
						$('#namaUser').val(editUser.nama);

						console.log(editUser);
					}
				}
			})
		}
	})
</script>