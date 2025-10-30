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
        $mail->Username = 'restagevira4@gmail.com';
        $mail->Password = 'wiyl rfrn frnm eije'; // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('restagevira4@gmail.com', 'Sistem Gudang');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Aktivasi Akun Anda';
        $mail->Body    = "Klik link berikut untuk aktivasi:<br><a href='$activation_link'>$activation_link</a>";

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
        $mail->Username = 'restagevira4@gmail.com';
        $mail->Password = 'wiyl rfrn frnm eije';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('restagevira4@gmail.com', 'Sistem Gudang');
        $mail->addAddress($email, $nama);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Anda';
        $mail->Body    = "Halo $nama,<br>Klik link berikut untuk reset password:<br><a href='$reset_link'>$reset_link</a><br>Link berlaku 1 jam.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
