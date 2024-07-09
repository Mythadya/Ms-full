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
    
    // Préparation de la requête SQL pour récupérer les informations du disque à supprimer
    $stmt = $db->prepare("SELECT d.* FROM disc d WHERE d.disc_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Récupération des données du disque
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si un disque est trouvé avec l'ID spécifié
    if ($album) {
     ?>
      <!-- Affichage du titre et du message de confirmation de suppression -->
      <h1>Supprimer le disque <?php echo $album['disc_title'];?></h1>
      <p>Êtes-vous sûr de vouloir supprimer ce disque?</p>
      
      <!-- Formulaire pour confirmer la suppression -->
      <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" value="Oui, supprimer">
        <a href="detail.php?id=<?php echo $id;?>">Non, annuler</a>
      </form>
      
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

// Si le formulaire de suppression est soumis
if (isset($_POST['id'])) {
  $id = $_POST['id'];
  
  // Préparation de la requête SQL pour supprimer le disque de la base de données
  $stmt = $db->prepare("DELETE FROM disc WHERE disc_id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  
  // Redirection vers la page d'accueil après suppression
  header('Location: index.php');
  exit;
}

?>
