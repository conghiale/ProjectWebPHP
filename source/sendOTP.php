<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require_once("conn_game.php");

    $mail = new PHPMailer(true);
    if (isset($_GET['email']) && isset($_GET['state']) && isset($_GET['message'])) {
        $email = $_GET['email'];
        $state = $_GET['state'];
        $message = $_GET['message'];

        $code_OTP = strval(rand(100000, 999999));
        $query = $conn->query("UPDATE users SET code_OTP='$code_OTP' WHERE email='$email'");
        if ($query){
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'legend.mighty28102002@gmail.com';
                $mail->Password   = 'arbobagmmpzjydlm';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                //Recipients
                $mail->setFrom('legend.mighty28102002@gmail.com', 'Kho Ung Dung Di Dong');
                $mail->addAddress($email);
                $mail->addReplyTo('legend.mighty28102002@gmail.com', 'Kho Ung Dung Di Dong');

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Verify account OTP';
                $mail->Body    = "<div style=\"font-family: 'Times New Roman', Times, serif; font-size: medium\">Your account verification code is: <b style=\"color: dodgerblue; font-weight: bold;\">$code_OTP</b></div>";

                if ($mail->send())
                    header("Location:verifyOTP.php?email=".$email."&state=".$state."&message=".$message);
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
?>