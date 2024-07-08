<?php

$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";


try {

  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $db->prepare("INSERT INTO disc (disc_title, artist_id, disc_year, disc_label, disc_genre, disc_price, disc_picture) VALUES (:disc_title, :artist_id, :disc_year, :disc_label, :disc_genre, :disc_price, :disc_picture)");

  $stmt->bindParam(':disc_title', $_POST['disc_title']);
  $stmt->bindParam(':artist_id', $_POST['artist_id']);
  $stmt->bindParam(':disc_year', $_POST['disc_year']);
  $stmt->bindParam(':disc_label', $_POST['disc_label']);

  $stmt->bindParam(':disc_genre', $_POST['disc_genre']);
  $stmt->bindParam(':disc_price', $_POST['disc_price']);
  $stmt->bindParam(':disc_picture', $_FILES['disc_picture']['name']);

  $stmt->execute();

  $target_dir ="pictures/";
  $target_file = $target_dir. basename($_FILES["disc_picture"]["name"]);
  move_uploaded_file($_FILES["disc_picture"]["tmp_name"], $target_file);

  header("Location: index.php");

} catch(PDOException $e) {
  echo "Erreur de connexion : ". $e->getMessage();
}

?>