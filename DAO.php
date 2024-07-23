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

    public function getPlats() {
        $stmt = $this ->pdo->prepare("SELECT * FROM plat LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCategoryById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlatsByCategory($categoryId) {
        $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE id_categorie = :id_categorie');
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlatById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
