<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?= $_title ?></title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/img/favicon.png')?>">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>">
	
	<!-- animation CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/css/animate.css')?>">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/css/select2.min.css')?>">

	<!-- Datatable CSS -->
	
	
	<!-- Feather CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/plugins/icons/feather/feather.css')?>">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/plugins/fontawesome/css/fontawesome.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/fontawesome/css/all.min.css')?>">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-datetimepicker.min.css')?>">

	<!-- Toatr CSS -->		
	<link rel="stylesheet" href="<?=base_url('assets/plugins/toastr/toatr.css')?>">

	<!-- Main CSS -->
	<link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">

	
	<?php
	if (isset($_daftarCss)) {
		foreach ($_daftarCss as $_css) {
			echo '<link rel="stylesheet" href="' . $_css . '"><br/>';
		}
	}
	?>
</head>