<?php

// Informations de connexion à la base de données MySQL
$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";

try {
  // Connexion à la base de données avec PDO
  $db = new PDO($dsn, $username, $password);
  
  // Configuration de PDO pour afficher les exceptions en cas d'erreur
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Préparation de la requête SQL d'insertion dans la table 'disc'
  $stmt = $db->prepare("INSERT INTO disc (disc_title, artist_id, disc_year, disc_label, disc_genre, disc_price, disc_picture) VALUES (:disc_title, :artist_id, :disc_year, :disc_label, :disc_genre, :disc_price, :disc_picture)");

  // Liaison des valeurs des paramètres avec les données soumises par le formulaire ($_POST et $_FILES)
  $stmt->bindParam(':disc_title', $_POST['disc_title']);
  $stmt->bindParam(':artist_id', $_POST['artist_id']);
  $stmt->bindParam(':disc_year', $_POST['disc_year']);
  $stmt->bindParam(':disc_label', $_POST['disc_label']);
  $stmt->bindParam(':disc_genre', $_POST['disc_genre']);
  $stmt->bindParam(':disc_price', $_POST['disc_price']);
  $stmt->bindParam(':disc_picture', $_FILES['disc_picture']['name']);

  // Exécution de la requête SQL
  $stmt->execute();

  // Déplacement du fichier image téléchargé vers le répertoire 'pictures/'
  $target_dir ="pictures/";
  $target_file = $target_dir. basename($_FILES["disc_picture"]["name"]);
  move_uploaded_file($_FILES["disc_picture"]["tmp_name"], $target_file);

  // Redirection vers la page principale après l'ajout du disque
  header("Location: index.php");

} catch(PDOException $e) {
  // Gestion des erreurs PDO en cas d'échec de la connexion ou de l'exécution de la requête
  echo "Erreur de connexion : ". $e->getMessage();
}

?>
