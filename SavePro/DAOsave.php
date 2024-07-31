<?php
class DAO {
    private $pdo;

    // Le constructeur de la classe prend un objet PDO et l'assigne à la propriété $pdo
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /* Ancien constructeur qui acceptait les paramètres de connexion à la base de données.
       Commenté car remplacé par l'utilisation d'un objet PDO directement passé au constructeur.
    public function __construct($db_host, $db_name, $db_user, $db_password) {
        try {
            $this->conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } */

    // Méthode pour récupérer toutes les catégories actives (limitées à 6)
    public function getCategories() {
        $stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE active = \'Yes\' LIMIT 6');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les catégories actives avec des colonnes spécifiques (limitées à 6)
    public function getActiveCategories() {
        $stmt = $this->pdo->prepare("SELECT id, libelle, image, active FROM categorie WHERE active = 'Yes' LIMIT 6");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer tous les plats (limités à 3)
    public function getPlats() {
        $stmt = $this->pdo->prepare("SELECT * FROM plat LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer une catégorie par son ID
    public function getCategoryById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM categorie WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer tous les plats d'une catégorie spécifique
    public function getPlatsByCategory($categoryId) {
        $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE id_categorie = :id_categorie');
        $stmt->execute(['id_categorie' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un plat par son ID
    public function getPlatById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les plats mis en avant (limités à 6) et actifs
    public function getFeaturedPlats() {
        // Vérification de la connexion à la base de données
        if ($this->pdo === null) {
            throw new RuntimeException('Database connection not established.');
        }

        try {
            // Préparation et exécution de la requête
            $stmt = $this->pdo->prepare('SELECT * FROM plat WHERE active = "Yes" LIMIT 6');
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Enregistrement de l'erreur et retour d'un tableau vide
            error_log('Query error: ' . $e->getMessage());
            return [];
        }
    }
}
?>
