<?php
// Configuration de la base de données
$host = 'localhost'; // Adresse du serveur de base de données
$db = 'District'; // Nom de votre base de données
$user = 'admin'; // Votre nom d'utilisateur pour la base de données
$pass = 'Afpa1234'; // Votre mot de passe pour la base de données

// Configuration pour utiliser les bonnes options avec PDO
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Activer les exceptions pour les erreurs
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Récupérer les résultats sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false, // Désactiver l'émulation des requêtes préparées pour plus de sécurité
];

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // En cas d'erreur, afficher le message d'erreur et arrêter l'exécution du script
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit;
}

// Requête SQL pour obtenir la liste des clients et le chiffre d'affaires généré par client
$sql = "SELECT 
            nom_client,
            SUM(quantite * total) AS chiffre_affaires
        FROM 
            commande
        GROUP BY 
            nom_client
        ORDER BY 
            chiffre_affaires DESC";

// Préparation et exécution de la requête SQL
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(); // Récupérer tous les résultats de la requête

// Fermeture de la connexion à la base de données
$pdo = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients et Chiffre d'Affaires</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse; /* Fusionner les bordures des cellules */
        }
        table, th, td {
            border: 1px solid black; /* Ajouter une bordure noire autour du tableau, des en-têtes et des cellules */
        }
        th, td {
            padding: 8px; /* Ajouter de l'espace à l'intérieur des cellules */
            text-align: left; /* Aligner le texte à gauche */
        }
        th {
            background-color: #f2f2f2; /* Ajouter une couleur de fond pour les en-têtes */
        }
    </style>
</head>
<body>
    <h1>Liste des Clients et Chiffre d'Affaires</h1>
    <table>
        <thead>
            <tr>
                <th>Nom du Client</th>
                <th>Chiffre d'Affaires</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <!-- Échapper les caractères spéciaux pour éviter les attaques XSS -->
                    <td><?php echo htmlspecialchars($row['nom_client'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(number_format($row['chiffre_affaires'], 2), ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
