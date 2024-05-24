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
						searchPlaceholder: "Cari Nomor Request...",
						},
				initComplete: (settings, json)=>{
				$('.dataTables_filter').appendTo('#tableSearch');
				$('.dataTables_filter').appendTo('.search-input');
			},
			"order"   : [],
			"ajax"    : {
				"url" : "<?= site_url('Permintaanbarang/getAll') ?>", 
				"type": "POST"
			},
			"columnDefs"   : [{
				"targets"  : [0],
				"orderable": false,
				"width": "10%"
			},{
                "className" : "text-center",
                "targets"   : [0, 1, 2, 3, 4, 5],   
            },{
				"targets": [1, 6, 7, 8 ],
				"orderable": false,
				"visible": false
			},{
				"className": "text-center", //for calling edit and delete button
				"targets": [-1],
				"data": null,
				"defaultContent": '<div class="me-3"><button type="button" class="btn btn-edit"><img src="<?= base_url('assets/img/icons/eye1.svg') ?>" alt="img"></i></button>'
			},{
				"targets": [2],
				"render": $.fn.dataTable.render.moment('DD-MM-YYYY')
			}],
		});

		$('#tabel').on('click', '.btn-edit', function() {
				var data = table.row($(this).parents('tr')).data();
				viewReq(data[1]);
		});
	}

	var detailData;
    $(document).ready(function(){
        pullData();
		var path = window.location.pathname.toString();
		var paths = path.split("/");

		if (paths.length == 5) {
			// alert(paths[4]);
			$.ajax({
				type: "get",
				url: "<?= site_url('Permintaanbarang/') ?>" + paths[4],

				dataType: "json",
				success: function(response) {
					if (response.success == true) {

						var mainData = response.result.mainData;
						detailData = response.result.detailData;

						$("#dataId").val(detailData.idBarang);

						detailData.forEach(function(data) {
							listDtData.push({
								id: data.idBarang,
								idDetailRequest: data.idDtRequest,
								idSatuanBarang: data.idSatuanBarang,
								nama: data.namaBarang,
								jumlahRequest: data.jumlah,
								satuanRequest: data.namaSatuan
							});
						});

						initTable();
						console.log(response.result.detailData);
					}
				}
			});
		}
    });

	function viewReq(id) {
		window.location.href = "<?= site_url('Permintaanbarang/permintaanViewReq') ?>/" + id
	}

	var listDtData = [];
	var tabelViewReq;

	function initTable() {
		tabelViewReq = $('#tabelViewReq').DataTable({
			// select: {
			// 		style: 'single',
			// 		items: 'cell',
			// 	},
			"processing": true,
			"serverside": false,
			"autowidth": false,
			"responsive": true,
			"bfilter": true,
			"sDom": 'ftlpi',
			"pagingType": 'numbers',
			"ordering": true,
			"aaData": listDtData,
			"aoColumns": [{
					"data": "id"
				}, {
					"data": "idDetailRequest"
				}, {
					"data": "idSatuanBarang"
				}, {
					"data": "nama"
				}, {
					"data": "jumlahRequest"
				}, {
					"data": "satuanRequest"
				}
			],
			"columnDefs": [{
				"targets": [0, 1, 2],
				"orderable": false,
				"visible": false
			}, {
				"className": "text-center",
				"targets": [0]
			}],
			"bDestroy": true,


		});
	}

	function kembali() {
		history.back();
	}
</script>

