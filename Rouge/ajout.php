<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=District';
$username = 'admin';
$password = 'Afpa1234';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit();
}

// Fonction pour ajouter une nouvelle catégorie et un plat
function addCategoryAndDish($pdo, $libelleCategorie, $imageCategorie, $libellePlat, $descriptionPlat, $prixPlat, $imagePlat) {
    // Préparation des requêtes avec des paramètres nommés
    $stmtCategorie = $pdo->prepare('INSERT INTO categorie (libelle, image, active) VALUES (:libelle, :image, 1)');
    $stmtPlat = $pdo->prepare('INSERT INTO plat (libelle, description, prix, image, id_categorie, active) VALUES (:libelle, :description, :prix, :image, :id_categorie, 1)');

    // Exécution des requêtes avec les paramètres
    $stmtCategorie->execute([':libelle' => $libelleCategorie, ':image' => $imageCategorie['name']]);
    $idCategorie = $pdo->lastInsertId();
    $stmtPlat->execute([':libelle' => $libellePlat, ':description' => $descriptionPlat, ':prix' => $prixPlat, ':image' => $imagePlat['name'], ':id_categorie' => $idCategorie]);

    return true;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $libelleCategorie = $_POST['libelle_categorie'];
    $imageCategorie = $_FILES['image_categorie'];
    $libellePlat = $_POST['libelle_plat'];
    $descriptionPlat = $_POST['description_plat'];
    $prixPlat = $_POST['prix_plat'];
    $imagePlat = $_FILES['image_plat'];

    if (addCategoryAndDish($pdo, $libelleCategorie, $imageCategorie, $libellePlat, $descriptionPlat, $prixPlat, $imagePlat)) {
        echo 'Catégorie et plat ajoutés avec succès !';
    } else {
        echo 'Erreur lors de l\'ajout de la catégorie et du plat.';
    }
}

// Affichage du formulaire
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

<h2>Ajouter une nouvelle catégorie et un plat</h2>

<div class="form-group">
  <label for="libelle_categorie">Libellé de la catégorie :</label>
  <input type="text" id="libelle_categorie" name="libelle_categorie" required class="form-control">
</div>

<div class="form-group">
  <label for="image_categorie">Image de la catégorie :</label>
  <input type="file" id="image_categorie" name="image_categorie" required class="form-control-file">
</div>
<hr>
<h3>Informations du plat</h3>

<div class="form-group">
  <label for="libelle_plat">Libellé du plat :</label>
  <input type="text" id="libelle_plat" name="libelle_plat" required class="form-control">
</div>

<div class="form-group">
  <label for="description_plat">Description du plat :</label>
  <textarea id="description_plat" name="description_plat" required class="form-control"></textarea>
</div>

<div class="form-group">
  <label for="prix_plat">Prix du plat :</label>
  <input type="number" id="prix_plat" name="prix_plat" required class="form-control">
</div>

<div class="form-group">
  <label for="image_plat">Image du plat :</label>
  <input type="file" id="image_plat" name="image_plat" required class="form-control-file">
</div>

<button type="submit" class="btn btn-primary">Ajouter</button>
</form>
<!-- Ajout de styles pour améliorer l'apparence du formulaire -->
<style>
.form-group {
  margin-bottom: 20px;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-control-file {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #4CAF50;
  color: #fff;
  cursor: pointer;
}

.btn:hover {
  background-color: #3e8e41;
}
</style>