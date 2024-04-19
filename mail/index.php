<?php
require 'vendor/autoload.php';
require '../session.php';
require '../validator.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

// try {
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com';
//     $mail->SMTPAuth = true;
//     $mail->Username = 'jagdishmaheshwari57@gmail.com'; // Use full email address if required
//     $mail->Password = 'enljtjwlyoenbcpi';
//     $mail->SMTPSecure = 'tsl'; // or 'ssl' depending on your provider
//     $mail->Port = 587;

//     $mail->SMTPDebug = 2;
//     $mail->Debugoutput = function ($str, $level) {
//     };

//     $mail->setFrom('jagdishmaheshwari57@gamil.com', 'Krazy Kart');
//     $mail->addAddress('jagdishmaheshwari1703@gmail.com', 'Jagdish Maheshwari');

//     $mail->isHTML(false);
//     $mail->Subject = 'This is test Mail';
//     $mail->Body = 'Hello Jagdish maheshwari this is test mail';

//     if($mail->send()){
//         echo 'Email sent successfully!';
//     }
// } catch (Exception $e) {
//     echo 'Error sending email: ', $mail->ErrorInfo;
// }


/**
 * Function to send OTP (One-Time Password) to a specified email address.
 *
 * @param string $recipientEmail The recipient's email address.
 * @param string $otp The OTP (One-Time Password) to send.
 * @return bool Returns true on successful email send, false on failure.
 */
function sendOTPByEmail($recipientEmail, $otp)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jagdishmaheshwari57@gmail.com'; // Use full email address if required
        $mail->Password = 'enljtjwlyoenbcpi';
        $mail->SMTPSecure = 'tsl'; // or 'ssl' depending on your provider
        $mail->Port = 587;

        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function ($str, $level) {
        };

        $mail->setFrom('jagdishmaheshwari57@gamil.com', 'Krazy Kart');
        $mail->addAddress($recipientEmail, '');

        $mail->isHTML(true);
        $mail->Subject = 'This is test Mail';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif;'>
                <p>Hello,</p>
                <p>Your One-Time Password (OTP) for authentication with Krazy Kart is: <h3><strong>$otp</strong></h3><br>Please use this OTP to complete your login or registration process with Krazy Kart.<br>Thank you!</p></div>";
                // </p>
                // <p>Please use this OTP to complete your login or registration process with Krazy Kart.</p>
                // <p>Thank you!</p>
                
        if ($mail->send()) {
            return true; 
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false; 
    }
}
if(isset($_POST['email'])){
    $Email = trim($_POST['email']);
    $OTP = generateRandomOTP(6);
    if (sendOTPByEmail($Email, $OTP)) {
        echo 'Success';
        $_SESSION['VerificationCode'] = $OTP;
        $_SESSION['EmailId'] = $Email;
    } else {
        echo 'NotFound';
    }
}
    
    /**
 * Function to generate a random OTP (One-Time Password) of a specified length.
 *
 * @param int $length The length of the OTP to generate.
 * @return string The generated OTP.
 */
function generateRandomOTP($length = 6)
{
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}
?>


