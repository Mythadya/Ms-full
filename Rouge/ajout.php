<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=District';
$username = 'admin';
$password = 'Afpa1234';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Erreur de connexion : '. $e->getMessage();
    exit();
}

// Création des tables si elles n'existent pas déjà
$pdo->query('CREATE TABLE IF NOT EXISTS categorie (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL
)');

$pdo->query('CREATE TABLE IF NOT EXISTS plat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    categorie_id INT,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id)
)');

// Formulaire pour ajouter une nouvelle catégorie et un plat
if (isset($_POST['submit'])) {
    $categorie_name = $_POST['categorie_name'];
    $plat_name = $_POST['plat_name'];
    $plat_description = $_POST['plat_description'];
    $plat_prix = $_POST['plat_prix'];

    // Ajout de la nouvelle catégorie
    $sql_categorie = 'INSERT INTO categorie (nom) VALUES (:categorie_name)';
    $stmt_categorie = $pdo->prepare($sql_categorie);
    $stmt_categorie->bindParam(':categorie_name', $categorie_name);
    $stmt_categorie->execute();

    // Récupération de l'ID de la nouvelle catégorie
    $categorie_id = $pdo->lastInsertId();

    // Ajout du plat dans la nouvelle catégorie
    $sql_plat = 'INSERT INTO plat (nom, description, prix, categorie_id) VALUES (:plat_name, :plat_description, :plat_prix, :categorie_id)';
    $stmt_plat = $pdo->prepare($sql_plat);
    $stmt_plat->bindParam(':plat_name', $plat_name);
    $stmt_plat->bindParam(':plat_description', $plat_description);
    $stmt_plat->bindParam(':plat_prix', $plat_prix);
    $stmt_plat->bindParam(':categorie_id', $categorie_id);
    $stmt_plat->execute();

    echo 'Nouvelle catégorie et plat ajoutés avec succès!';
}

// Formulaire HTML pour ajouter une nouvelle catégorie et un plat
?>
<form method="post">
    <label for="categorie_name">Nom de la catégorie :</label>
    <input type="text" id="categorie_name" name="categorie_name"><br><br>
    <label for="plat_name">Nom du plat :</label>
    <input type="text" id="plat_name" name="plat_name"><br><br>
    <label for="plat_description">Description du plat :</label>
    <textarea id="plat_description" name="plat_description"></textarea><br><br>
    <label for="plat_prix">Prix du plat :</label>
    <input type="number" id="plat_prix" name="plat_prix"><br><br>
    <input type="submit" name="submit" value="Ajouter">
</form>