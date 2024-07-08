<?php
$dsn = "mysql:host=localhost;dbname=record";
$username = "admin";
$password = "Afpa1234";

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $db->prepare("SELECT * FROM artist");
  $stmt->execute();
  $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
  echo "Erreur de connexion : ". $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un disque</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Ajouter un disque</h1>
    <form action="add_script.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="disc_title">Titre du disque</label>
        <input type="text" class="form-control" id="disc_title" name="disc_title" required>
      </div>
      <div class="form-group">
        <label for="artist_id">Artiste</label>
        <select class="form-control" id="artist_id" name="artist_id" required>
          <?php foreach ($artists as $artist) :?>
            <option value="<?php echo $artist['artist_id'];?>"><?php echo $artist['artist_name'];?></option>
          <?php endforeach;?>
        </select>
      </div>
      <div class="form-group">
        <label for="disc_year">Année de sortie</label>
        <input type="number" class="form-control" id="disc_year" name="disc_year" required>
      </div>
      <div class="form-group">
        <label for="disc_label">Label</label>
        <input type="text" class="form-control" id="disc_label" name="disc_label" required>
      </div>
      <div class="form-group">
        <label for="disc_genre">Genre</label>
        <input type="text" class="form-control" id="disc_genre" name="disc_genre" required>
      </div>
      <div class="form-group">
        <label for="disc_price">Prix</label>
        <input type="number" class="form-control" id="disc_price" name="disc_price" required>
      </div>
      <div class="form-group">
        <label for="disc_picture">Image du disque</label>
        <input type="file" class="form-control" id="disc_picture" name="disc_picture" required>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>