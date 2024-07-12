<?php
// Informations de connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=District';
$username = 'admin';
$password = 'Afpa1234';

// Créer une instance de PDO
$pdo = new PDO($dsn, $username, $password);

// Définir le mode d'erreur pour afficher les erreurs
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requête SQL pour supprimer les plats non actifs
$sql = "DELETE FROM plat WHERE active = 'Non'";

// Préparer et exécuter la requête
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Vérifier si la requête a réussi
if ($stmt->rowCount() > 0) {
    echo "Les plats non actifs ont été supprimés avec succès.";
} else {
    echo "Aucun plat non actif trouvé.";
}

// Fermer la connexion
$pdo = null;
?>