<?php
class DAO {
    private $pdo;

    // Constructeur qui initialise l'objet PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour récupérer toutes les catégories actives (limitées à 6)
    public function getCategories() {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE active = :active LIMIT 6');
            $stmt->execute(['active' => 'Yes']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching categories: ' . $e->getMessage());
            return [];
        }
    }

    // Méthode pour récupérer les catégories actives avec des colonnes spécifiques (limitées à 6)
    public function getActiveCategories() {
        try {
            $stmt = $this->pdo->prepare("SELECT id, libelle, image, active FROM categorie WHERE active = :active LIMIT 6");
            $stmt->execute(['active' => 'Yes']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching active categories: ' . $e->getMessage());
            return [];
        }
    }

    // Méthode pour récupérer tous les plats (limités à 3)
    public function getPlats() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM plat LIMIT 3");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching plats: ' . $e->getMessage());
            return [];
        }
    }

    // Méthode pour récupérer une catégorie par son ID
    public function getCategoryById($id) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching category by ID: ' . $e->getMessage());
            return null;
        }
    }

    // Méthode pour récupérer tous les plats d'une catégorie spécifique
    public function getPlatsByCategory($categoryId) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE id_categorie = :id_categorie');
            $stmt->execute(['id_categorie' => $categoryId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching plats by category: ' . $e->getMessage());
            return [];
        }
    }

    // Méthode pour récupérer un plat par son ID
    public function getPlatById($id) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching plat by ID: ' . $e->getMessage());
            return null;
        }
    }

    // Méthode pour récupérer les plats mis en avant (limités à 6) et actifs
    public function getFeaturedPlats() {
        if ($this->pdo === null) {
            throw new RuntimeException('Database connection not established.');
        }

        try {
            $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE active = :active LIMIT 6');
            $stmt->execute(['active' => 'Yes']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching featured plats: ' . $e->getMessage());
            return [];
        }
    }
}
?>
