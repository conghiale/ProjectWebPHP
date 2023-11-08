<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">-->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>-->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <link rel="stylesheet" href="form-login.css">
    <title>Document</title>
    <style>
        span.has-error {
            color:red;
            font-size: small;
        }
        .showMessage {
            position: absolute;
            left: 0;
            bottom: -100px;
            width: 400px;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.8);
            box-shadow: 0px 0px 17px 2px rgba(255, 255, 255, 0.8);
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="login">
        <form id="form-login" method="post" action="" role="form" name="login">
            <a href="index.php"><img class="img-register" src="index_img/logo.png" alt=""></a>
            <h1 class="form-heading mt-2">Login</h1>
            <div class="form-group mb-3 mt-3">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-input" id="email" name="email" placeholder="conghiale28102002@gmail.com">
            </div>
            <div class="form-group mb-5 mt-2">
                <i class="fa-solid fa-lock"></i>
                <i class="fa-solid fa-eye" id="eye"></i>
                <input type="password" class="form-input" id="pass" name="pass" placeholder="Password">
            </div>
            <input class="form-submit" type="submit" value="Login" onclick="checkValid()">

            <div class="mt-2" style="font-weight: bold">
                <a href=""  id="forgot_password">Forgot Password</a>
                <a href="register.php" style="float: right">Register a new account</a>
            </div>
            <div id="verifyAccount"><a href="" id="verify_Account">Account Verification</a></div>
            <div class='alert alert-success showMessage fade' role='alert'>Login successfully</div>
        </form>
    </div>
    <?php
        require_once("conn_game.php");
        $state = "";
        $message = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST['email']) && isset($_POST['pass'])){
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $flag = false;

                $stmt = $conn->query("SELECT * FROM users WHERE email='$email'");
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row['state'] == "verified"){
                        if ($row['pass'] == $pass){
                            header("Location:index.php?email=".$email);
                        }else {
                            $GLOBALS['state'] = "failure";
                            $GLOBALS['message'] = "Wrong password";
                        }
                    }else {
                        $GLOBALS['state'] = "failure";
                        $GLOBALS['message'] = "This account is not verified";
                    }
                } else {
                    $GLOBALS['state'] = "failure";
                    $GLOBALS['message'] = "This account is not registered";
                }
            }
        }
    ?>
    <?php
        if (isset($_GET['state']) && isset($_GET['message'])){
            $GLOBALS['state'] = $_GET['state'];
            $GLOBALS['message'] = $_GET['message'];
        }
    ?>
    <script defer>
        let state, message, showMessage
        showMessage = $('.showMessage')
        state = "<?php echo $state ?>"
        message = "<?php echo $message ?>"

        $(document).ready(function () {
            if (showMessage.hasClass('fade'))
                showMessage.removeClass('fade')
            showMessage.hide()

            $('#eye').click(function () {
                $(this).toggleClass('fa-sharp fa-eye-slash fa-eye open')
                if($(this).hasClass('open'))
                    $('#pass').attr('type', 'text')
                else
                $('#pass').attr('type', 'password')
            })

            if (state != "") {
                if (state == "success") {
                    if (showMessage.hasClass('alert-danger'))
                        showMessage.toggleClass('alert-danger alert-success')
                }else {
                    if (showMessage.hasClass('alert-success'))
                        showMessage.toggleClass('alert-success alert-danger')
                }
                showMessage.html(message)
                showMessage.fadeIn(500)
                setTimeout(function () {
                    showMessage.fadeOut(1000)
                }, 3000)
            }

            $('#forgot_password').click(() => {
                location.assign("forgot_password.php?state=forgot_password&message=&id_form=1")
                return false
            })
            $('#verify_Account').click(() => {
                location.assign("forgot_password.php?state=verify_Account&message=&id_form=1")
                return false
            })
        });
        $.validator.setDefaults({
            errorElement: 'span',
            errorClass: 'has-error',
        });
        function checkValid() {
            console.log("signIn")
            $("#form-login").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    pass: {
                        required: true,
                        minlength: 6
                    },
                },
                messages: {
                    email: "Please enter a valid email address",
                    pass: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            })
        };
    </script>
</body>
</html>