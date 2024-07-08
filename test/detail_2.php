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
      <h1>Modifier le disque <?php echo $album['disc_title'];?></h1>
      <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <label for="artist_id">Artiste :</label>
        <select name="artist_id" id="artist_id">
          <?php
          $stmt = $db->prepare("SELECT artist_id, artist_name FROM artist");
          $stmt->execute();
          $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach ($artists as $artist) {
            $selected = ($artist['artist_id'] == $album['artist_id']) ? 'selected' : '';
            echo "<option value='{$artist['artist_id']}' $selected>{$artist['artist_name']}</option>";
          }
          ?>
        </select><br><br>
        <label for="disc_title">Titre :</label>
        <input type="text" name="disc_title" value="<?php echo $album['disc_title'];?>"><br><br>
        <label for="disc_year">Année :</label>
        <input type="number" name="disc_year" value="<?php echo $album['disc_year'];?>"><br><br>
        <label for="disc_label">Label :</label>
        <input type="text" name="disc_label" value="<?php echo $album['disc_label'];?>"><br><br>
        <label for="disc_genre">Genre :</label>
        <input type="text" name="disc_genre" value="<?php echo $album['disc_genre'];?>"><br><br>
        <label for="disc_price">Prix :</label>
        <input type="number" name="disc_price" value="<?php echo $album['disc_price'];?>"><br><br>
        <label for="disc_picture">Image :</label>
        <input type="file" name="disc_picture"><br><br>
        <input type="submit" value="Modifier">
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
?>