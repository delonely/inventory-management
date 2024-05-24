<!-- jQuery -->
<script src="<?=base_url('assets/js/jquery-3.6.0.min.js')?>"></script>

<!-- Feather Icon JS -->
<script src="<?=base_url('assets/js/feather.min.js')?>"></script>

<!-- Slimscroll JS -->
<script src="<?=base_url('assets/js/jquery.slimscroll.min.js')?>"></script>


<!-- Bootstrap Core JS -->
<script src="<?=base_url('assets/js/bootstrap.bundle.min.js')?>"></script>

<!-- Sweetalert 2 -->
<!-- <script src="<?=base_url('assets/plugins/sweetalert/sweetalert2.all.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/sweetalert/sweetalerts.min.js')?>"></script> -->

<!-- Chart JS -->
<script src="<?=base_url('assets/plugins/apexchart/apexcharts.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/apexchart/chart-data.js')?>"></script>

<!-- Custom JS -->
<script src="<?=base_url('assets/js/script.js')?>"></script>


<?php
if (isset($_daftarJs)) {
	foreach ($_daftarJs as $_js) {
		echo '<script src="' . $_js . '"></script><br/>';
	}
}

// if (isset($_includeFooter)){
// 	foreach ($_includeFooter as $_footer){
// 		include $_footer;
// 	}
// }
?>
</body>