<?php

error_reporting(E_ALL); // Enable error reporting for all types of errors
ini_set('error_log', 'error.log'); // Log errors to a file named "error.log"

$to = 'Mailhog@mail.com';
$subject = 'Test Mailhog';
$message = 'Bonjour, ceci est un test de Mailhog!';
$headers = 'From: votre_email@example.com'. "\r\n".
           'Reply-To: votre_email@example.com'. "\r\n".
           'X-Mailer: PHP/'. phpversion();

ini_set('SMTP', '127.0.0.1');
ini_set('smtp_port', '1025');

$mail = mail($to, $subject, $message, $headers);

if (!$mail) {
    $error = error_get_last();
    if ($error) {
        error_log("Erreur lors de l'envoi de l'email: " . $error['message']);
        echo "Erreur lors de l'envoi de l'email: " . $error['message'] . "\n";
    } else {
        error_log("Erreur lors de l'envoi de l'email: Erreur inconnue");
        echo "Erreur lors de l'envoi de l'email: Erreur inconnue\n";
    }
} else {
    echo 'Email envoyé avec succès!';
}

?>