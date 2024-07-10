<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des plats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Liste des plats</h1>
    <table>
        <thead>
            <tr>
                <th>Plat</th>
                <th>Description</th>
                <th>Prix (€)</th>
                <th>Catégorie</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connexion à la base de données
            $dsn = 'mysql:host=localhost;dbname=District;charset=utf8';
            $username = 'admin';
            $password = 'Afpa1234';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                $pdo = new PDO($dsn, $username, $password, $options);

                // Requête SQL pour récupérer les données des plats avec leur catégorie
                $sql = "SELECT p.libelle AS nom_plat, p.description AS description_plat, p.prix AS prix_plat, 
                c.libelle AS nom_categorie
                FROM plat p
                JOIN categorie c ON p.id_categorie = c.id";

                // Préparation et exécution de la requête
                $stmt = $pdo->query($sql);

                // Affichage des résultats
                while ($row = $stmt->fetch()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['nom_plat']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description_plat']) . '</td>';
                    echo '<td>' . number_format($row['prix_plat'], 2, ',', ' ') . '</td>';
                    echo '<td>' . htmlspecialchars($row['nom_categorie']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row['image_plat']) . '" alt="Image du plat"></td>';
                    echo '</tr>';
                }
            } catch (PDOException $e) {
                echo 'Erreur de connexion : ' . $e->getMessage();
            }

            // Fermeture de la connexion à la base de données
            $pdo = null;
            ?>
        </tbody>
    </table>
</body>
</html>
