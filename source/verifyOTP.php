<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <link rel="stylesheet" href="form-verifyOTP.css">
    <title>SingUp</title>
    <style>
        span.has-error {
            color:red;
            font-size: small;
        }
        .showMessage {
            position: absolute;
            left: 0px;
            bottom: -100px;
            width: 400px;
            background: rgba(0, 0, 0, 0.8);
            box-shadow: 0px 0px 17px 2px rgba(255, 255, 255, 0.8);
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
        require_once("conn_game.php");
        $state = "";
        $message = "";
        $email = "";
        if (isset($_GET['email']) && isset($_GET['state']) && isset($_GET['message'])) {
            $GLOBALS['email'] = $_GET['email'];
            $GLOBALS['state'] = $_GET['state'];
            $GLOBALS['message'] = $_GET['message'];
        }
    ?>
    <div id="verifyOTP">
        <form action="" id="form-verifyOTP" method="post" role="form" name="verifyOTP">
            <h2 class="form-heading">Verify OTP</h2>
            <h5 id="note">Enter the OTP sent to email: </h5>
            <div class="form-group mb-3 mt-4">
                <i class="fa-solid fa-user-lock"></i>
                <input type="number" class="form-input" placeholder="Entrer OTP" name="code_OTP">
            </div>
            <div id="messResendOTP">Dont receive the OTP? <?php
                    echo "<a href='sendOTP.php?email=".$email."&state=failure&message=Please check your email' id='resendOTP'>Resend OTP</a>";
                ?>
            </div>
            <input type="submit" value="Verify" class="form-submit mt-2" onclick="checkValid()">
            <div class='alert alert-success showMessage fade' role='alert'>Registration successfully</div>
        </form>
    </div>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST['code_OTP'])){
                $code_OTP = $_POST['code_OTP'];

                $stmt = $conn->query("SELECT * FROM users WHERE code_OTP='$code_OTP'");
                if ($stmt->rowCount() > 0) {
                    echo $state;
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $row['id'];
                    if ($row['state'] == "not verified"){
                        $state = "verified";
                        $query = $conn->query("UPDATE users SET state='$state', code_OTP='' WHERE id='$id'");
                        if($query){
                            header("Location:signin.php?message=The account has been verified&state=success");
                        }else{
                            $GLOBALS['state'] = "failure";
                            $GLOBALS['message'] = "Error while verifying account. Please try again later.";
                        }
                    }else {
                        $query = $conn->query("UPDATE users SET code_OTP='' WHERE id='$id'");
                        if($query){
                            header("Location:forgot_password.php?message=Account verification successful. Please enter a new password&state=success&email=".$email."&id_form=2");
                        }else{
                            $GLOBALS['state'] = "failure";
                            $GLOBALS['message'] = "Error while verifying account. Please try again later.";
                        }
                    }
                } else {
                    $GLOBALS['state'] = "failure";
                    $GLOBALS['message'] = "Invalid OTP code";
                }
            }
        }
    ?>
    <?php
        header("sendOTP.php?email=".$email."&state=failure&message=Please check your email.");
    ?>
    <script defer>
        let state, message, showMessage, email, note
        showMessage = $('.showMessage')
        note = $('#note')
        state = "<?php echo $state ?>"
        message = "<?php echo $message ?>"
        email = "<?php echo $email ?>"
        $(document).ready(() => {
            note.html("Enter the OTP sent to email: <b>" + email + "</b>")
            if (showMessage.hasClass('fade'))
                showMessage.removeClass('fade')
            showMessage.hide();
            if (state != "") {
                if (state == "success") {
                    if (showMessage.hasClass('alert-danger'))
                        showMessage.toggleClass('alert-danger alert-success')
                } else {
                    if (showMessage.hasClass('alert-success'))
                        showMessage.toggleClass('alert-success alert-danger')
                }
                showMessage.html(message)
            }
            showMessage.fadeIn(500)
            setTimeout(function () {
                showMessage.fadeOut(1000)
            }, 3000)
        })
        $.validator.setDefaults({
            errorElement: 'span',
            errorClass: 'has-error',
        });
        function checkValid() {
            console.log("VerifyOTP")
            $("#form-verifyOTP").validate({
                rules: {
                    code_OTP: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    code_OTP: {
                        required: "Please provide a your OTP code",
                        number: "Invalid OTP code",
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