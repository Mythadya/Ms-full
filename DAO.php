<?php
class DAO {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


    /* public function __construct($db_host, $db_name, $db_user, $db_password) {
        try {
            $this->conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } */

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

    public function getFeaturedPlats() {
        if ($this->pdo === null) {
            throw new RuntimeException('Database connection not established.');
        }

        try {
            // Filtrer uniquement par active = 'Yes'
            $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE active = "Yes" LIMIT 6');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Query error: ' . $e->getMessage());
            return [];
        }
    }
}
?>
