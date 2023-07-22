
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = "criosoguttest@gmail.com";
        
        

        # Sender Data
        $subject = trim($_POST["subject"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , 
        strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);

        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($phone) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Por favor. Complete el formulario y vuelva a intentarlo.";
            exit;
        }

        # Mail Content
        $content = "Name: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Phone: $phone\n";
        $content .= "Message:\n$message\n";

        # email headers.
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        $headers .= "From: ". $email. "\r\n";
        $headers .= "Reply-To: ". $mail_to. "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        $headers .= "X-Priority: 1" . "\r\n"; 

        # Send the email.
        $success = mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "¡Gracias! Tu mensaje ha sido enviado.";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "¡Ups! Algo salió mal, no pudimos enviar su mensaje.";
        }

        } else {
            # Not a POST request, set a 403 (forbidden) response code.
            http_response_code(403);
            echo "Hubo un problema con su envío, inténtelo de nuevo.";
        }
?>
