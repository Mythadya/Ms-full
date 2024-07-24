<?php
try 
{        
    $db = new PDO('mysql:host=localhost;charset=utf8;dbname=record', 'admin', 'Afpa1234');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $requete = $db->query("SELECT * FROM artist");
    $tableau = $requete->fetchAll(PDO::FETCH_OBJ);
    $requete->closeCursor();
} catch (Exception $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "N° : " . htmlspecialchars($e->getCode());
    die("Fin du script");
}       
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test PDO</title>
</head>
<body>
    <h1>Liste des artistes</h1>
    <?php foreach ($tableau as $artist): ?>
        <div>
            <?= htmlspecialchars($artist->artist_name) ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
