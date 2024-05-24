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
    /**
     * button keluar
     */
    function keluar(){
        //window.history.back();
        /**
         * link back sementara, pakai history back kurang cocok
         */
        location.href = "http://localhost/pengadaan-un/";
    }
    /*end button keluar*/

    /**
     * start tombol unduh
     */
    function cetakLapPersediaan(tanggal){
        var tanggal_cetak = $('#datetimepicker2').val();

        if (tanggal_cetak == ''){
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
			toastr["error"]("Tanggal: Silahkan pilih tanggal terlebih dahulu")
			return false;
        }else{
            window.location.href = "<?= site_url('LapPersediaan')?>/" + tanggal;
            // $.ajax({
            //     url: "<?= site_url('LapPersediaan')?>/" + tanggal,
            //     type: 'get',
            //     // dataType: "html",
            //     data:,
            //     success: function(response){
            //        var file = new Blob([response], {type: 'application/pdf'});
            //        var fileURL = URL.createObjectURL(file);

            //        var printWindow = window.open();
            //        printWindow.print();
            //     },
            //     error: function(jqXHR, textStatus, errorThrown) {
            //     console.error('There has been a problem with your jQuery Ajax operation:', errorThrown);
            //     }
            // });
        }
    }
</script>