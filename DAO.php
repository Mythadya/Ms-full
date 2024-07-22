<?php
class DAO {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function getCategories() {

        $stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE active = \'Yes\' LIMIT 6');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveCategories() {
        $stmt = $this->pdo->prepare("SELECT id, libelle, image, active FROM categorie WHERE active = 'Yes' LIMIT 6");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
