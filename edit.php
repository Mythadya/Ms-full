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
    
    // Préparation de la requête SQL pour récupérer les détails du vinyle avec l'artiste associé
    $stmt = $db->prepare("SELECT d.*, a.artist_name, d.disc_picture 
                          FROM disc d 
                          INNER JOIN artist a ON d.artist_id = a.artist_id 
                          WHERE d.disc_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Récupération des données du vinyle et de l'artiste
    $album = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si un vinyle est trouvé avec l'ID spécifié
    if ($album) {
      // Vérification si le formulaire a été soumis en méthode POST
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $title = $_POST['title'];
        $artist_id = $_POST['artist'];
        $year = $_POST['year'];
        $label = $_POST['label'];
        $genre = $_POST['genre'];
        $price = $_POST['price'];

        // Préparation de la requête SQL pour mettre à jour le vinyle dans la base de données
        $updateStmt = $db->prepare("UPDATE disc 
                                    SET disc_title = :title, 
                                        artist_id = :artist, 
                                        disc_year = :year, 
                                        disc_label = :label, 
                                        disc_genre = :genre, 
                                        disc_price = :price 
                                    WHERE disc_id = :id");
        $updateStmt->bindParam(':title', $title);
        $updateStmt->bindParam(':artist', $artist_id);
        $updateStmt->bindParam(':year', $year);
        $updateStmt->bindParam(':label', $label);
        $updateStmt->bindParam(':genre', $genre);
        $updateStmt->bindParam(':price', $price);
        $updateStmt->bindParam(':id', $id);

        // Exécution de la requête de mise à jour
        if ($updateStmt->execute()) {
          echo "Le vinyle a été mis à jour avec succès.";
          header('Location: index.php');
          exit();
        } else {
          echo "Une erreur s'est produite lors de la mise à jour du vinyle.";
        }
      } else {
        // Si la méthode HTTP n'est pas POST, récupérer les artistes pour afficher dans le formulaire
        $artistStmt = $db->prepare("SELECT * FROM artist");
        $artistStmt->execute();
        $artists = $artistStmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage du formulaire de modification du vinyle
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier un vinyle</title>
            <style>
                /* Styles CSS pour la mise en page */
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
                            <option value="<?php echo $artist['artist_id'];?>" <?php if ($artist['artist_id'] == $album['artist_id']) echo 'selected';?>><?php echo $artist['artist_name'];?></option>
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
      // Si aucun vinyle n'est trouvé avec l'ID spécifié
      echo "Aucun vinyle trouvé avec cet ID";
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
