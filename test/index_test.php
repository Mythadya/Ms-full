<?php

$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT d.*, a.artist_name, d.disc_picture FROM disc d INNER JOIN artist a ON d.artist_id = a.artist_id WHERE d.disc_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($album) {
   ?>
      <h1>Détail du disque <?php echo $album['disc_title'];?></h1>
      <img src="pictures/<?php echo $album['disc_picture'];?>" alt="<?php echo $album['disc_title'];?>">
      <p>
        <strong>Artiste :</strong> <?php echo $album['artist_name'];?><br>
        <strong>Année :</strong> <?php echo $album['disc_year'];?><br>
        <strong>Label :</strong> <?php echo $album['disc_label'];?><br>
        <strong>Genre :</strong> <?php echo $album['disc_genre'];?><br>
        <strong>Prix :</strong> <?php echo $album['disc_price'];?> €<br>
      </p>
      <p>
        <a href="cart.php?action=add&id=<?php echo $id;?>">
          <button>Ajouter au panier</button>
        </a>
      </p>
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
?>