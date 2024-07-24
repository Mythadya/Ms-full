<?php

include 'DAO.php';
include 'header.php';

// Connexion à la base de données
$db_host = "localhost";
$db_name = "District";
$db_user = "admin";
$db_password = "Afpa1234";
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);


// Requête SQL pour récupérer les plats

$sql = "SELECT * FROM plat LIMIT 6";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Affichage des plats dans des cartes

echo "<div class='containerx2'>";

while ($plat = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo "<div class='cardx2'>";
  echo "<img src='images_the_district  (1)/food/" . $plat['image'] . "' class='card-img-top' alt='" . $plat['libelle'] . "'>";
  echo "<div class='card-bodyx2'>";
  echo "<h5 class='card-title'>" . $plat['libelle'] . "</h5>";
  echo "<p class='card-text'>" . $plat['description'] . "</p>";
  echo "<p class='card-text'>Prix : " . $plat['prix'] . " €</p>";
  echo "<button class='btn btn-primary'>Commander</button>";
  echo "</div>";
  echo "</div>";
}

echo "</div>";

include 'footer.php';

?>