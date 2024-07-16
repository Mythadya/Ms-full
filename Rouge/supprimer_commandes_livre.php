<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "admin";
    $password = "Afpa1234";  
    $dbname = "District";

    try {
        // Créer une connexion PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        // Définir le mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour supprimer les commandes avec le statut 'Livrée'
        $sql = "DELETE FROM commande WHERE etat = 'Livrée'";

        // Préparer et exécuter la requête
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        echo "Les commandes avec le statut 'Livrée' ont été supprimées avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Suppression</title>
    <script>
        function confirmDeletion() {
            return confirm("Êtes-vous sûr de vouloir supprimer toutes les commandes avec le statut 'Livrée' ?");
        }
    </script>
</head>
<body>
    <form method="POST" onsubmit="return confirmDeletion();">
        <button type="submit">Supprimer les commandes livrées</button>
    </form>
</body>
</html>
