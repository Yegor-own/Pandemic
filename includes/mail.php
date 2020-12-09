<?php 

require_once('phpmailer/PHPMailerAutoload.php');
$email = new PHPMailer;
$email->CharSet = 'utf-8';

//$email->SMTPDebug = 3;                               // Enable verbose debug output

$email->isSMTP();                                      // Set mailer to use SMTP
$email->Host = 'smtp.gmail.com';  																							// Specify main and backup SMTP servers
$email->SMTPAuth = true;                               // Enable SMTP authentication
$email->Username = 'egor891712@gmail.com'; // Ваш логин от почты с которой будут отправляться письма
$email->Password = 'laTErIdAHoAD'; // Ваш пароль от почты с которой будут отправляться письма
$email->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$email->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

$email->setFrom('egor891712@gmail.com'); // от кого будет уходить письмо?
$email->addAddress('health0crowdsourcing@gmail.com');     // Кому будет уходить письмо 
//$email->addAddress('ellen@example.com');               // Name is optional
//$email->addReplyTo('info@example.com', 'Information');
//$email->addCC('cc@example.com');
//$email->addBCC('bcc@example.com');
//$email->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$email->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$email->isHTML(true);                                  // Set email format to HTML

$email->Subject = 'Вызов скорой помощи';
$email->Body    = 'Вызов скорой помощи произошел по адресу';
$email->AltBody = '';

if(!$email->send()) {
    echo 'Error';
} else {
    header('location: thank-you.html');
}
?>