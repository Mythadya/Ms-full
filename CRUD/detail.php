<?php

// Informations de connexion à la base de données
$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";

try {
  // Connexion à la base de données avec PDO
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Vérification si un ID est passé en paramètre GET
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Préparation de la requête SQL pour récupérer les détails du disque avec l'artiste associé
    $stmt = $db->prepare("SELECT d.*, a.artist_name, d.disc_picture 
                          FROM disc d 
                          INNER JOIN artist a ON d.artist_id = a.artist_id 
                          WHERE d.disc_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Récupération des données du disque et de l'artiste
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si un disque est trouvé avec l'ID spécifié
    if ($album) {
     ?>
      <!-- Affichage des détails du disque -->
      <h1>Détail du disque <?php echo $album['disc_title'];?></h1>
      <img src="pictures/<?php echo $album['disc_picture'];?>" alt="<?php echo $album['disc_title'];?>">
      <p>
        <strong>Artiste :</strong> <?php echo $album['artist_name'];?><br>
        <strong>Année :</strong> <?php echo $album['disc_year'];?><br>
        <strong>Label :</strong> <?php echo $album['disc_label'];?><br>
        <strong>Genre :</strong> <?php echo $album['disc_genre'];?><br>
        <strong>Prix :</strong> <?php echo $album['disc_price'];?> €<br>
      </p>
      
      <!-- Liens pour éditer, supprimer et retourner -->
      <a href="edit.php?id=<?php echo $album['disc_id'];?>">Modifier</a>
      <a href="delete.php?id=<?php echo $album['disc_id'];?>">Supprimer</a>
      <a href="index.php?id=<?php echo $album['disc_id'];?>">Retour</a>
      
      <?php
    } else {
      // Si aucun disque n'est trouvé avec l'ID spécifié
      echo "Aucun disque trouvé avec cet ID";
    }
  } else {
    // Si aucun ID n'est passé en paramètre GET
    echo "Erreur : ID manquant";
  }

} catch(PDOException $e) {
  // En cas d'erreur lors de la connexion à la base de données
  echo "Erreur de connexion : ". $e->getMessage();
}

?>
