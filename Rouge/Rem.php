<?php
// Configuration
$hôte_bd = 'localhost';
$nom_utilisateur_bd = 'admin';
$mot_de_passe_bd = 'Afpa1234';
$nom_bd = 'District';

// Créez une instance PDO
$dsn = "mysql:host=$hôte_bd;dbname=$nom_bd";
$nom_utilisateur = $nom_utilisateur_bd;
$mot_de_passe = $mot_de_passe_bd;

try {
    $pdo = new PDO($dsn, $nom_utilisateur, $mot_de_passe);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Échec de la connexion : '. $e->getMessage();
    exit();
}

// Préparez la requête SQL pour récupérer tous les plats
$sql = "SELECT libelle, prix
        FROM plat
        ORDER BY prix ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupérez les résultats
$résultats = $stmt->fetchAll();

// Affichez le tableau
echo "<table border='1'>";
echo "<tr><th>Libellé</th><th>Prix</th></tr>";

foreach ($résultats as $résultat) {
    echo "<tr>";
    echo "<td>" . $résultat["libelle"] . "</td>";
    echo "<td>" . $résultat["prix"] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Trouvez le plat le plus rentable
$max_prix = 0;
$plat_le_plus_rentable = "";

foreach ($résultats as $résultat) {
    if ($résultat["prix"] > $max_prix) {
        $max_prix = $résultat["prix"];
        $plat_le_plus_rentable = $résultat["libelle"];
    }
}

echo "<p>Le plat le plus rentable est : " . $plat_le_plus_rentable . " avec un prix de " . $max_prix . "</p>";

// Fermez la connexion
$pdo = null;
?>