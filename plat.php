<?php
// Inclusion des fichiers nécessaires pour la logique de la page
include 'DAO.php'; // Fichier qui contient la classe DAO pour accéder aux données
include 'header.php'; // Fichier d'en-tête HTML

// Connexion à la base de données
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Définition des paramètres de connexion
    $dsn = 'mysql:host=localhost;dbname=District';
    $username = 'admin';
    $password = 'Afpa1234';

    // Création d'une instance PDO pour se connecter à la base de données
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active le mode de gestion des erreurs
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Définit le mode de récupération par défaut
        PDO::ATTR_EMULATE_PREPARES => false // Désactive l'émulation des requêtes préparées
    ]);
    // Connexion réussie
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    error_log('Database connection error: ' . $e->getMessage()); // Enregistre l'erreur dans un fichier de log
    die('Unable to connect to the database.'); // Affiche un message générique à l'utilisateur
}

// Création d'une instance de la classe DAO avec la connexion PDO
$dao = new DAO($pdo);

// Récupération des plats
$plats = $dao->getFeaturedPlats();

if (empty($plats)) {
    echo "No active plats found";
} else {
    // Affichage des plats dans des cartes
    echo "<div class='containerx2'>";
    foreach ($plats as $plat) {
        echo "<div class='cardx2'>";
        echo "<img src='images_the_district  (1)/food/" . htmlspecialchars($plat['image']) . "' class='card-img-top' alt='" . htmlspecialchars($plat['libelle']) . "'>";
        echo "<div class='card-bodyx2'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($plat['libelle']) . "</h5>";
        echo "<p class='card-text'>" . htmlspecialchars($plat['description']) . "</p>";
        echo "<p class='card-text'>Prix : " . htmlspecialchars($plat['prix']) . " €</p>";
        echo "<form action='commande.php' method='post'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($plat['id']) . "'>";
        echo "<input type='hidden' name='libelle' value='" . htmlspecialchars($plat['libelle']) . "'>";
        echo "<input type='hidden' name='prix' value='" . htmlspecialchars($plat['prix']) . "'>";
        echo "<input type='hidden' name='image' value='images_the_district  (1)/food/" . htmlspecialchars($plat['image']) . "'>";
        echo "<button type='submit' class='btn btn-primary'>Commander</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
}

include 'footer.php';

?>