<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendActivationEmail($email, $activation_link) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Sistem Gudang');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Aktivasi Akun Anda';
        $mail->Body    = "Halo, klik link berikut untuk aktivasi akun Anda:<br>
                         <a href='$activation_link'>$activation_link</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function sendResetPasswordEmail($email, $nama, $reset_link) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Sistem Gudang');
        $mail->addAddress($email, $nama);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Anda';
        $mail->Body    = "Halo $nama,<br> Klik link berikut untuk mereset password Anda:<br>
                          <a href='$reset_link'>$reset_link</a><br>
                          Link ini berlaku 1 jam.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
