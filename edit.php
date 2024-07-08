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
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $artist_id = $_POST['artist'];
        $year = $_POST['year'];
        $label = $_POST['label'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];

        $updateStmt = $db->prepare("UPDATE disc SET disc_title = :title, artist_id = :artist, disc_year = :year, disc_label = :label, disc_genre = :genre, disc_price = :price WHERE disc_id = :id");
        $updateStmt->bindParam(':title', $title);
        $updateStmt->bindParam(':artist', $artist_id);
        $updateStmt->bindParam(':year', $year);
        $updateStmt->bindParam(':label', $label);
        $updateStmt->bindParam(':genre', $genre);
        $updateStmt->bindParam(':price', $price);
        $updateStmt->bindParam(':id', $id);

        if ($updateStmt->execute()) {
          echo "Le disque a été mis à jour avec succès.";
          header('Location: index.php');
          exit();
        } else {
          echo "Une erreur s'est produite lors de la mise à jour du disque.";
        }
      } else {
        $artistStmt = $db->prepare("SELECT * FROM artist");
        $artistStmt->execute();
        $artists = $artistStmt->fetchAll(PDO::FETCH_ASSOC);

       ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier un vinyle</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                header {
                    background-color: #333;
                    color: white;
                    padding: 10px;
                    display: flex;
                    justify-content: space-between;
                }

                header a {
                    color: white;
                    text-decoration: none;
                    margin-right: 10px;
                }

                main {
                    padding: 20px;
                    max-width: 800px;
                    margin: 0 auto;
                }

                main h1 {
                    text-align: center;
                    margin-bottom: 20px;
                }

                main label {
                    display: block;
                    margin-bottom: 5px;
                }

                main input[type="text"],
                main input[type="number"],
                main select {
                    width: 100%;
                    padding: 5px;
                    margin-bottom: 10px;
                }

                main button {
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px;
                    border: none;
                    cursor: pointer;
                    margin-top: 10px;
                }

                main button:hover {
                    background-color: #45a049;
                }

                main img {
                    border-radius: 5px;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <header>
                <nav>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="add.php">Ajouter un vinyle</a></li>
                    </ul>
                </nav>
            </header>
            <main>
                <h1>Modifier un vinyle</h1>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $album['disc_id'];?>">
                    <label for="title">Titre :</label>
                    <input type="text" name="title" id="title" value="<?php echo $album['disc_title'];?>">

                    <label for="artist">Artiste :</label>
                    <select name="artist" id="artist">
                        <?php foreach ($artists as $artist):?>
                            <option value="<?php echo $artist['artist_id'];?>" <?php if ($artist['artist_id'] == $album['artist_id']) echo 'elected';?>><?php echo $artist['artist_name'];?></option>
                        <?php endforeach;?>
                    </select>

                    <label for="year">Année :</label>
                    <input type="number" name="year" id="year" value="<?php echo $album['disc_year'];?>">

                    <label for="label">Label :</label>
                    <input type="text" name="label" id="label" value="<?php echo $album['disc_label'];?>">

                    <label for="genre">Genre :</label>
                    <input type="text" name="genre" id="genre" value="<?php echo $album['disc_genre'];?>">

                    <label for="price">Prix :</label>
                    <input type="number" name="price" id="price" value="<?php echo $album['disc_price'];?>">

                    <label for="picture">Image :</label>
                    <input type="file" name="picture" id="picture" accept="image/*">
                    <img src="<?php echo $album['disc_picture'];?>" alt="Image du vinyle" width="100">

                    <button type="submit">Enregistrer</button>
                </form>
            </main>
        </body>
        </html>
       <?php
      }
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