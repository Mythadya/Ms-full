<?php

$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $db->prepare("SELECT d.*, a.artist_name FROM disc d INNER JOIN artist a ON d.artist_id = a.artist_id LIMIT 15 ");
  $stmt->execute();
  $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Disques</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Liste des Disques</h1>
    <div class="row">
      <?php foreach ($albums as $album) :?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="pictures/<?php echo $album['disc_picture'];?>" class="card-img-top"?>
            <div class="card-body">
              <h5 class="card-title"><?php echo $album['disc_title'];?></h5>
              <p class="card-text">
                <small class="text-muted">Artiste: <?php echo $album['artist_name'];?></small><br>
                <small class="text-muted">Année: <?php echo $album['disc_year'];?></small><br>
                <small class="text-muted">Label: <?php echo $album['disc_label'];?></small><br>
                <small class="text-muted">Genre: <?php echo $album['disc_genre'];?></small><br>
                <small class="text-muted">Prix: <?php echo $album['disc_price'];?> €</small><br>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach;?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
} catch(PDOException $e) {
  echo "Erreur de connexion : ". $e->getMessage();
}
?>