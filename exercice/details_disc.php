<?php
    $db = new PDO('mysql:host=localhost;charset=utf8;dbname=record', 'admin', 'Afpa1234');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $db->prepare("select * from disc where disc_id=?");
    $requete->execute(array($_GET["disc_id"]));
    $disc = $requete->fetch(PDO::FETCH_OBJ);

    if ($disc === null) {
        echo "<p>Le disque n'existe pas!</p>";
    } else {
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Détail du disque</title>
</head>
<body>
    <h1>Détail du disque</h1>
    <p>Disc N° <?= $disc->disc_id?></p>
    <p>Disc name <?= $disc->disc_name?></p>
    <p>Disc year <?= $disc->disc_year?></p>
</body>
</html>
<?php
    }
?>