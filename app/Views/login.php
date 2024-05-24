<?php
include $templatePath . 'head.php';
?>

<body class="account-page">
    <div class="row justify-content-left"> 
        <div class="main-wrapper">
            <div class="account-content">
                <div class="login-wrapper">
                    <div class="login-content">
                        <div class="login-userset bg-back"> 
                            <form method="post" id="loginForm">
                                <div class="bg-back" style="height:150px;max-width: 100%">
                                    <img src="assets/img/sip.png" alt="imglogin"/>
                                 </div>
                                <div class="login-userheading" style="text-align:center">
                                    <h4 id="errMsg" style="color:red;"><h4>
                                </div>
                                <div class="form-login" style="max-width: 300px; margin: 0px 100px 20px 100px">
                                    <label>Username</label>
                                    <div class="form-addons">
                                        <input type="text" id="user" name="user" placeholder="Username anda" autofocus=true>
                                        <img src="assets/img/icons/mail.svg" alt="img">
                                    </div>
                                </div>
                                <div class="form-login" style="max-width: 300px; margin: 0px 100px 30px 100px ">
                                    <label>Password</label>
                                    <div class="pass-group">
                                        <input type="password" id="pass" name="pass" class="pass-input" placeholder="Password anda">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                                <div class="form-login" style="max-width: 300px;margin: 0px 100px 30px 100px">
                                    <input type="submit" class="btn btn-login" value="Masuk"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="bg-back">
                        <img src="assets/img/homepage2.png" alt="imglogin" />
                    </div>
                </div>
            </div>
        </div>
    </div>   

    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <!-- Feather Icon JS -->
    <script src="assets/js/feather.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <script>
        $(document).ready(function () {
            $("#loginForm").submit(function (event) {
                event.preventDefault();
                var formData = {};
                var user = $("#user").val(); 
                var pass = $("#pass").val(); 

                var xData = JSON.stringify(formData);
                $.ajax({
                    type: "POST",
                    url: "<?= base_url("auth") ?>",
                    data: {
                        u: user,
                        p: pass
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success == true) {
                            window.location.href = "<?=base_url()?>";
                        } else {
                        
                            $("#errMsg").html(response.message);
                            $("#user").focus();
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    },
                });
            });
        });
    </script>

</body>

</html>