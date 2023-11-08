<!DOCTYPE    html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <link rel="stylesheet" href="form-forgot-password.css">

    <title>Forgot Password</title>
    <style>
        span.has-error {
            color:red;
            font-size: small;
        }
        .showMessage {
            position: absolute;
            left: 0;
            bottom: -120px;
            width: 400px;
            background: rgba(0, 0, 0, 0.8);
            box-shadow: 0px 0px 17px 2px rgba(255, 255, 255, 0.8);
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh">
        <div id="forgot-password">
            <form class="form-forgot-password-sendOTP" method="post" action="" role="form" name="form-forgot-password-sendOTP">
                <a href="index.php"><img class="img-forgot-password-sendOTP" src="index_img/logo.png" alt=""></a>
                <h2 class="form-heading mt-2">Send OTP</h2>
                <div class="form-group mb-5 mt-3">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" class="form-input" id="email" name="email" placeholder="conghiale28102002@gmail.com">
                </div>
                <input class="form-submit" name="sendOTP" id="sendOTP" type="submit" value="Send OTP" onclick="checkValid()">
                <div class='alert alert-success showMessage fade' role='alert'>Enter your email address to authenticate your account</div>
            </form>

            <form class="form-forgot-password" method="post" action="" role="form" name="forgotPassword">
                <a href="index.php"><img class="img-forgot-password" src="index_img/logo.png" alt=""></a>
                <h2 class="form-heading mt-2">Forgot Password</h2>
                <div class="form-group mb-3 mt-2">
                    <i class="fa-solid fa-lock"></i>
                    <i class="fa-solid fa-eye" id="eye_new_pass"></i>
                    <input type="password" class="form-input" id="new_pass" name="new_pass" placeholder="New Password">
                </div>
                <div class="form-group mb-5 mt-2">
                    <i class="fa-solid fa-unlock-keyhole"></i>
                    <i class="fa-solid fa-eye" id="eye_confirm_new_pass"></i>
                    <input type="password" class="form-input" id="confirm_new_pass" name="confirm_new_pass" placeholder="Confirm New Password">
                </div>
                <input class="form-submit" type="submit" name="getPassword" id="getPassword" value="Get Password" onclick="checkValid()">
                <div class='alert alert-success showMessage fade' role='alert'>Forgot password</div>
            </form>
        </div>
    </div>
    <?php
        require_once("conn_game.php");
        $state = "";
        $message = "";
        $id_form = "1";
        $email = "";
        if (isset($_GET['state']) && isset($_GET['message']) && isset($_GET['id_form'])){
            $GLOBALS['state'] = $_GET['state'];
            $GLOBALS['message'] = $_GET['message'];
            $GLOBALS['id_form'] = $_GET['id_form'];
        }
        if (isset($_GET['email'])) {
            $GLOBALS['email'] = $_GET['email'];
        }
    ?>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST['new_pass']) && isset($_POST['getPassword'])){
                $new_pass = $_POST['new_pass'];

                $stmt = $conn->query("SELECT * FROM users WHERE email='$email'");
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $row['id'];
                    $query = $conn->query("UPDATE users SET pass='$new_pass' WHERE id='$id'");
                    if ($query) {
                        header("Location:signin.php?email=".$email."&state=success&message=Change password Successfully");
                    }else {
                        $GLOBALS['state'] = "failure";
                        $GLOBALS['message'] = "Password change failed. Please try again.";
                    }
                }
            }
        }
    ?>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST['email']) && isset($_POST['sendOTP'])){

                $email = $_POST['email'];
                $stmt = $conn->query("SELECT * FROM users WHERE email='$email'");
                if ($stmt->rowCount() > 0){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($state == "forgot_password") {
                        if ($row['state'] == "verified"){
                            header("Location:sendOTP.php?email=".$email."&state=success&message=Please check your email to verify your account");
                        }else{
                            $GLOBALS['state'] = "failure";
                            $GLOBALS['message'] = "This account has not been verified";
                        }
                    }
                    if ($state == "verify_Account") {
                        if ($row['state'] == "verified"){
                            $GLOBALS['state'] = "success";
                            $GLOBALS['message'] = "This account has been verified.";
                        }else{
                            header("Location:sendOTP.php?email=".$email."&state=success&message=Please check your email to verify your account");
                        }
                    }
                }else {
                    $GLOBALS['state'] = "failure";
                    $GLOBALS['message'] = "This account is not registered.";
                }
            }
        }
    ?>
    <script defer>
        let state, message, id_form, showMessage
        showMessage = $('.showMessage')
        state = "<?php echo $state ?>"
        message = "<?php echo $message ?>"
        id_form = "<?php echo $id_form ?>"

        if (id_form == "1"){
            $('.form-forgot-password').css('visibility', 'hidden')
            $('.form-forgot-password-sendOTP').css('visibility', 'visible')
        } else {
            $('.form-forgot-password-sendOTP').css('visibility', 'hidden')
            $('.form-forgot-password').css('visibility', 'visible')
        }

        $(document).ready(function () {
            if (showMessage.hasClass('fade'))
                showMessage.removeClass('fade')
            showMessage.hide()

            if (state != "")  {
                if (state == "success") {
                    if (showMessage.hasClass('alert-danger'))
                        showMessage.toggleClass('alert-danger alert-success')
                }else {
                    if (showMessage.hasClass('alert-success'))
                        showMessage.toggleClass('alert-success alert-danger')
                }
                if (message != "")
                    showMessage.html(message)
                showMessage.fadeIn(500)
                setTimeout(function () {
                    showMessage.fadeOut(1000)
                }, 3000)
            }

            $('#eye_new_pass').click(function () {
                $(this).toggleClass('fa-sharp fa-eye-slash fa-eye open')
                if($(this).hasClass('open'))
                    $('#new_pass').attr('type', 'text')
                else
                    $('#new_pass').attr('type', 'password')
            })

            $('#eye_confirm_new_pass').click(function () {
                $(this).toggleClass('fa-sharp fa-eye-slash fa-eye open')
                if($(this).hasClass('open'))
                    $('#confirm_new_pass').attr('type', 'text')
                else
                    $('#confirm_new_pass').attr('type', 'password')
            })
        });

        $.validator.setDefaults({
            errorElement: 'span',
            errorClass: 'has-error',
        });
        function checkValid() {
            console.log("register")
            $(".form-forgot-password").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    new_pass: {
                        required: true,
                        minlength: 6
                    },
                    confirm_new_pass: {
                        required: true,
                        minlength: 6,
                        equalTo: "#new_pass"
                    }
                },
                messages: {
                    email: "Please enter a valid email address",
                    new_pass: {
                        required: "Please provide a new password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    confirm_new_pass: {
                        required: "Please confirm new password",
                        minlength: "Your password must be at least 6 characters long",
                        equalTo: "Invalid password"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            })
            $('.form-forgot-password-sendOTP').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    email: "Please enter a valid email address",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            })
        };
    </script>
</body>
</html>