<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mettre à jour les prix des Pizzas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mettre à jour les prix des Pizzas</h1>
        <?php
        // Configuration de la base de données
        $host = 'localhost';
        $db = 'District';
        $user = 'admin';
        $pass = 'Afpa1234';
        
        try {
            // Connexion à la base de données
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Préparation de la requête pour obtenir l'ID de la catégorie 'Pizza'
            $stmt = $pdo->prepare("SELECT id FROM categorie WHERE libelle = :libelle");
            $stmt->execute(['libelle' => 'Pizza']);
            $category = $stmt->fetch();
            
            if ($category) {
                // Préparation de la requête pour mettre à jour les prix
                $update_stmt = $pdo->prepare("UPDATE plat SET prix = prix * 1.10 WHERE id_categorie = :id_categorie");
                $update_stmt->execute(['id_categorie' => $category['id']]);
                
                echo "<p>Les prix des plats de la catégorie 'Pizza' ont été mis à jour avec succès.</p>";
            } else {
                echo "<p>Catégorie 'Pizza' introuvable.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erreur : " . $e->getMessage() . "</p>";
        }
        ?>
        <button onclick="window.location.reload();">Mettre à jour à nouveau</button>
    </div>
</body>
</html>
