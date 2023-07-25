<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// se requiere de estos tres archivos bajados desde github - https://github.com/PHPMailer/PHPMailer
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
// Función para enviar la respuesta automática
function enviarRespuestaAutomatica($email, $name) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                           //Enable verbose debug output
        $mail->isSMTP();                                //Send using SMTP
        $mail->CharSet = 'UTF-8';                       // se habilita signos UTF-8
        $mail->Host       = 'smtp.gmail.com';           //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                       //Enable SMTP authentication
        $mail->Username   = 'criosoguttest@gmail.com';  //SMTP username
        $mail->Password   = 'aleumyagctlojxhk';         // se habilita contraseña de aplicacion en gmail, contraseña temporal SMTP correoSMTPcontacto, no utilizar contraseña de acceso de gmail
        $mail->SMTPSecure = 'tls';                      //Enable implicit TLS encryption
        $mail->Port       = 587;                        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //Recipients
        $mail->setFrom('criosoguttest@gmail.com', 'Cotizacion');
        $mail->addAddress($email, $name);
        //Content
        $mail->isHTML(true); 
        //Set email format to HTML
        $mail->Subject = 'Respuesta automática - Cotización';
        $mail->Body    = <<<EOT
        Hola {$name},:<br/>
        Esta es una respuesta automática.
        <br/>
        Gracias por contactarnos!
        <br/>
        Hemos recibido tu mensaje y nos pondremos en contacto contigo en las próximas 24 horas. <br/>
        <br/>
        Saludos,<br/>
        Equipo Pan Gourmet Chile
        EOT;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
//enviar correo original
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 0;                           //Enable verbose debug output
    $mail->isSMTP();                                //Send using SMTP
    $mail->CharSet = 'UTF-8';                       // se habilita signos UTF-8
    $mail->Host       = 'smtp.gmail.com';           //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                       //Enable SMTP authentication
    $mail->Username   = 'criosoguttest@gmail.com';  //SMTP username
    $mail->Password   = 'aleumyagctlojxhk';         // se habilita contraseña de aplicacion en gmail, contraseña temporal SMTP correoSMTPcontacto, no utilizar contraseña de acceso de gmail
    $mail->SMTPSecure = 'tls';                      //Enable implicit TLS encryption
    $mail->Port       = 587;                        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    //Recipients
    $mail->setFrom('criosoguttest@gmail.com', 'Cotizacion');
    $mail->addAddress('criosoguttest@gmail.com');   //Add a recipient
    //Reply to (Respuesta automática)
    $replyEmail = $_POST['email'];
    $replyName = $_POST['name'];
    $mail->addReplyTo($replyEmail, $replyName);
    //Content
    $mail->isHTML(true); 
    //Set email format to HTML
    $mail->Subject = 'Cotización';
    $mail->Body    = <<<EOT
    Nombre:	{$_POST['name']}<br/>
    Correo: {$_POST['email']}<br/>
    Teléfono: {$_POST['phone']}<br/>
    Asunto: {$_POST['subject']}<br/>
    Mensaje: {$_POST['message']}<br/>
    EOT;
    $mail->send();
    // Envío de la respuesta automática
    enviarRespuestaAutomatica($replyEmail, $replyName);
    echo 'Mensaje enviado!... favor revisa tu bandeja de entrada';
} catch (Exception $e) {
    echo "Error al enviar... {$mail->ErrorInfo}";
}
