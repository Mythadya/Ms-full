<?php

$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT d.* FROM disc d WHERE d.disc_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($album) {
     ?>
      <h1>Supprimer le disque <?php echo $album['disc_title'];?></h1>
      <p>Êtes-vous sûr de vouloir supprimer ce disque?</p>
      <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" value="Oui, supprimer">
        <a href="detail.php?id=<?php echo $id;?>">Non, annuler</a>
      </form>
      <?php
    } else {
      echo "Aucun disque trouvé avec cet ID";
    }
  } else {
    echo "Erreur : ID manquant";
  }

} catch(PDOException $e) {
  echo "Erreur de connexion : ". $e->getMessage();
}

if (isset($_POST['id'])) {
  $id = $_POST['id'];
  $stmt = $db->prepare("DELETE FROM disc WHERE disc_id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  header('Location: index.php');
  exit;
}
?>