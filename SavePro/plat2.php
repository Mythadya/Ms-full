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
    echo "<form action='commande.php' method='post'>";
    echo "<input type='hidden' name='id' value='". htmlspecialchars($plat['id']). "'>";
    echo "<input type='hidden' name='libelle' value='". htmlspecialchars($plat['libelle']). "'>";
    echo "<input type='hidden' name='prix' value='". htmlspecialchars($plat['prix']). "'>";
    echo "<input type='hidden' name='image' value='images_the_district  (1)/food/". htmlspecialchars($plat['image'])."'>";
    echo "<button type='submit' class='btn btn-primary'>Commander</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
  }
  echo "</div>";
}

include 'footer.php';

?>