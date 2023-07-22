<?php
//SE REQUIERE PHPMAILES + SMTP
require("class.phpmailer.php");
require("class.smtp.php");

$mail = new PHPMailer();
$mail->isSMTP();

// SE ACTIVA LA CODIFICACION UTF-8 PARA SIGNOS
$mail->CharSet = 'UTF-8';

// SE INGRESA EL SERVIDOR SMTP Y EL PUERTO 465 PARA GMAIL ES EL 587
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->SMTPSecure = true;

// INGRESAR CORREO Y PASSWORD
$mail->Username = 'criosoguttest@gmail.com';
$mail->Password = 'aleumyagctlojxhk';

// CORREO ELECTRONICO DE: CONTACTO@BLA...
$mail->From = 'criosoguttest@gmail.com';
// TITULO DEL CORREO A RECIBIR
$mail->FromName = "Pan Gourmet Chile - Cotización";
//
$mail->AddAddress('criosoguttest@gmail.com', "PanGourmet");
//$mail->AddAddress($_POST['email']);
// CON COPIA
//$mail->addCC('correo_x@gmail.com');
// CON COPIA OCULTA
//$mail->addBCC('correo_x@hotmail.cl');

$mail->WordWrap = 50;
$mail->IsHTML(true);

//TITULO DEL CORREO A RECIBIR (ASUNTO)
$mail->Subject = "Cotización";
//CUERPO DEL CORREO DESDE EL NOMBRE HASTA EL MENSAJE
$mail->Body    = <<<EOT
Nombre:	{$_POST['name']}<br/>
Correo: {$_POST['email']}<br/>
Teléfono: {$_POST['phone']}<br/>
Asunto: {$_POST['subject']}<br/>
Mensaje: {$_POST['message']}<br/>
EOT;


$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);


if(!$mail->Send())

{
   echo "Error al enviar. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
//MENSAJE PARA EL CLIENTE INDICANDO MENSAJE ENVIADO
echo "Mensaje enviado!";


	
?> 
