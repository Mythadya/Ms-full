<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des commandes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Liste des commandes</h2>

<table>
    <thead>
        <tr>
            <th>Date de commande</th>
            <th>Informations du client</th>
            <th>Plat</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>

    <?php

    // Paramètres de connexion à la base de données
    $servername = "localhost";
    $username = "admin";
    $password = "Afpa1234";
    $dbname = "District";

    try {
        // Connexion à la base de données MySQL
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Configuration des attributs de PDO pour afficher les erreurs
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour récupérer les données nécessaires
        $sql = "SELECT c.date_commande, CONCAT('<br>', c.telephone_client, '<br>', c.email_client, '<br>', c.adresse_client) as client_info, p.libelle, p.prix
                FROM commande c
                JOIN plat p ON c.id_plat = p.id";

        // Exécution de la requête
        $stmt = $conn->query($sql);

        // Vérification s'il y a des résultats à afficher
        if ($stmt->rowCount() > 0) {
            // Parcours des résultats et affichage dans le tableau HTML
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["date_commande"] . "</td>";
                echo "<td>" . $row["client_info"] . "</td>";
                echo "<td>" . $row["libelle"] . "</td>";
                echo "<td>" . $row["prix"] . "</td>";
                echo "</tr>";
            }
        } else {
            // Si aucun résultat trouvé, affiche un message dans une seule cellule du tableau
            echo "<tr><td colspan='4'>Aucun résultat trouvé.</td></tr>";
        }
    } catch(PDOException $e) {
        // Capture des erreurs PDO et affichage du message d'erreur
        echo "Error: " . $e->getMessage();
    }
    
    // Fermeture de la connexion à la base de données
    $conn = null;
    ?>

    </tbody>
</table>

</body>
</html>
