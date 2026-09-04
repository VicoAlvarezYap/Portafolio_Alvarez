<?php

//enlace con php mailer(volver a descargar el archivo)
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class contactoController {

    public function enviarEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nombre  = trim($_POST['nombre'] ?? '');
            $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $mensaje = trim($_POST['mensaje'] ?? '');

            if (!$nombre || !$email || !$mensaje) {
                header('Location: index.php?action=contacto&status=error_datos');
                exit();
            }

            $mail = new PHPMailer(true);

           try {
                $mail->isSMTP();
                $mail->Host       = 'sandbox.smtp.mailtrap.io'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = '04ccee25f040f5';         
                $mail->Password   = 'a0bd7f62ac99b9'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 2525;                       
                $mail->CharSet    = 'UTF-8';

               $mail->setFrom('contacto@tuportafolio.com', 'Portafolio Contacto');
               $mail->addAddress('tu_correo@ejemplo.com', 'Alvaro'); // Debe ser un email válido
               $mail->addReplyTo($email, $nombre);

        
               $mail->isHTML(true);
               $mail->Subject = "Nuevo mensaje de contacto de: $nombre";
               $mail->Body    = "
                <h3>Has recibido un nuevo mensaje desde el Portafolio:</h3>
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje)) . "</p> ";
  
               $mail->send();
               header('Location: index.php?action=inicio&status=success#contacto');
                exit();
            } catch (Exception $e) {
 
            die("Error de PHPMailer: " . $mail->ErrorInfo);}
        }
    }
}