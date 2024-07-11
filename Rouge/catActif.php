<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; 
$db = 'District'; 
$user = 'admin'; 
$pass = 'Afpa1234'; 

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL
    $sql = "SELECT c.id, c.libelle, COUNT(*) AS nombre_plats_actifs
            FROM plat p
            JOIN categorie c ON p.id_categorie = c.id
            WHERE p.active = 'Yes'
            GROUP BY c.id, c.libelle";

    // Exécution de la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupération des résultats
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Plats Actifs par Catégorie</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 50px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tableau des Plats Actifs par Catégorie</h1>
    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
                <th>Nombre de Plats Actifs</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($resultats)) : ?>
                <?php foreach ($resultats as $row) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['libelle']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_plats_actifs']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="2">Aucun résultat trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
