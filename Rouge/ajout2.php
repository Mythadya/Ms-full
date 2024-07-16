<?php
// Connexion à la base de données
$servername = "localhost";
$username = "admin";
$password = "Afpa1234";
$dbname = "District";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : ". $conn->connect_error);
}

// Récupération des données du formulaire
$nom_categorie = $_POST['nom_categorie'];
$nom_plat = $_POST['nom_plat'];
$description_plat = $_POST['description_plat'];
$prix_plat = $_POST['prix_plat'];

// Ajout de la nouvelle catégorie
$sql = "INSERT INTO categorie (libelle, image, active) VALUES ('$nom_categorie', '', 'Yes')";
if ($conn->query($sql) === TRUE) {
    $categorie_id = $conn->insert_id;
} else {
    echo "Erreur lors de l'ajout de la catégorie : ". $sql. "<br>". $conn->error;
}

// Ajout du plat dans la nouvelle catégorie
$sql = "INSERT INTO plat (libelle, description, prix, categorie_id) VALUES ('$nom_plat', '$description_plat', '$prix_plat', $id)";
if ($conn->query($sql) === TRUE) {
    echo "Nouvelle catégorie et plat ajoutés avec succès!";
} else {
    echo "Erreur lors de l'ajout du plat : ". $sql. "<br>". $conn->error;
}

$conn->close();
?>