<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$to = 'mailhog@mail.com';
$subject = 'Email de test';
$message = 'Ceci est un email de test.';
$headers = 'From: webmaster@example.com'. "\r\n".
           'Reply-To: webmaster@example.com'. "\r\n".
           'X-Mailer: PHP/'. phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo 'Email envoyé avec succès';
} else {
    echo 'Échec de l\'envoi de l\'email';
}
?>