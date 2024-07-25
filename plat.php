<?php

include 'DAO.php';
include 'header.php';

// Connexion à la base de données
$db_host = "localhost";
$db_name = "District";
$db_user = "admin";
$db_password = "Afpa1234";

$dao = new DAO($db_host, $db_name, $db_user, $db_password);

// Récupération des plats
$plats = $dao->getFeaturedPlats();


if (empty($plats)) {
  echo "No featured plats found";
} else {
  // Affichage des plats dans des cartes
  echo "<div class='containerx2'>";
  foreach ($plats as $plat) {
    echo "<div class='cardx2'>";
    echo "<img src='images_the_district  (1)/food/". htmlspecialchars($plat['image']). "' class='card-img-top' alt='". htmlspecialchars($plat['libelle']). "'>";
    echo "<div class='card-bodyx2'>";
    echo "<h5 class='card-title'>". htmlspecialchars($plat['libelle']). "</h5>";
    echo "<p class='card-text'>". htmlspecialchars($plat['description']). "</p>";
    echo "<p class='card-text'>Prix : ". htmlspecialchars($plat['prix']). " €</p>";
    echo "<button class='btn btn-primary'>Commander</button>";
    echo "</div>";
    echo "</div>";
  }
  echo "</div>";
}

include 'footer.php';

?>
