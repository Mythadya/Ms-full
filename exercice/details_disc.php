<?php
try {
    $db = new PDO('mysql:host=localhost;charset=utf8;dbname=record', 'admin', 'Afpa1234');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<p>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

if (!isset($_GET['disc_id']) || !is_numeric($_GET['disc_id'])) {
    echo "<p>ID de disque invalide!</p>";
    exit;
}

$requete = $db->prepare("SELECT * FROM disc WHERE disc_id = ?");
$requete->execute(array($_GET["disc_id"]));
$disc = $requete->fetch(PDO::FETCH_OBJ);

if ($disc === null) {
    echo "<p>Le disque n'existe pas!</p>";
} else {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du disque</title>
</head>
<body>
    <h1>Détail du disque</h1>
    <p>Disc N° <?= htmlspecialchars($disc->disc_id) ?></p>
    <p>Disc name <?= htmlspecialchars($disc->disc_name) ?></p>
    <p>Disc year <?= htmlspecialchars($disc->disc_year) ?></p>
</body>
</html>
<?php
}
?>
