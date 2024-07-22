<?php
require 'dao/DAO.php';
require 'vendor/autoload.php'; // Assurez-vous que PHPMailer est installé via Composer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dao = new DAO();
    $dish = $dao->get_dish_by_id($_POST['dish_id']);
    
    // Sauvegarde de la commande
    $order = [
        'name' => 'Nom du client', // À remplacer par un formulaire de collecte de données
        'email' => 'email@example.com', // À remplacer par un formulaire de collecte de données
        'dish_id' => $dish['id'],
        'quantity' => 1 // À remplacer par un formulaire de collecte de données
    ];
    $orderId = $dao->save_order($order);

    // Envoi de l'email de confirmation
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'votre_email@example.com';
        $mail->Password = 'votre_mot_de_passe';
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('votre_email@example.com', 'Site Resto');
        $mail->addAddress($order['email'], $order['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de commande';
        $mail->Body    = 'Merci pour votre commande. Voici les détails : <br>' .
            'Plat : ' . htmlspecialchars($dish['name']) . '<br>' .
            'Quantité : ' . htmlspecialchars($order['quantity']);

        $mail->send();
        echo 'Le message a été envoyé';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    }
} else {
    header('Location: plats.php');
}
