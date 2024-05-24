<script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalerts.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>

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

	// $('#datetimepicker2').datetimepicker( {
	// 	maxDate: moment(),
	// 	allowInputToggle: true,
	// 	enabledHours : false,
	// 	locale: moment().local('id'),
	// 	format: 'DD-MM-YYYY'
	// });
</script>