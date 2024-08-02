<?php
// Inclusion des fichiers nécessaires pour la logique de la page
include 'DAO.php'; // Fichier qui contient la classe DAO pour accéder aux données. Assure-toi qu'il est sécurisé.
include 'header.php'; // Fichier d'en-tête HTML. Vérifie qu'il ne contient pas de code malveillant.

// Connexion à la base de données
try {
    // Définition des paramètres de connexion
    $dsn = 'mysql:host=localhost;dbname=District';
    $username = 'admin';
    $password = 'Afpa1234';

    // Création d'une instance PDO pour se connecter à la base de données
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active le mode de gestion des erreurs
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Définit le mode de récupération par défaut
        PDO::ATTR_EMULATE_PREPARES => false // Désactive l'émulation des requêtes préparées
    ]);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    error_log('Database connection error: ' . $e->getMessage()); // Enregistre l'erreur dans un fichier de log pour le débogage
    die('Unable to connect to the database.'); // Affiche un message générique à l'utilisateur
}

$categoryDAO = new DAO($pdo); // Création d'une instance de la classe DAO avec la connexion PDO

// Récupération du terme de recherche depuis l'URL, avec nettoyage pour éviter les problèmes de sécurité
$searchTerm = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search']), ENT_QUOTES, 'UTF-8') : '';

// Récupération des catégories et des plats depuis la base de données avec gestion des erreurs
try {
    $categories = $categoryDAO->getCategories(); // Récupère les catégories depuis la base de données
    $plats = $categoryDAO->getPlats(); // Récupère les plats depuis la base de données
} catch (Exception $e) {
    // Gestion des erreurs lors de la récupération des données
    error_log('Data retrieval error: ' . $e->getMessage()); // Enregistre l'erreur dans un fichier de log
    die('Unable to retrieve data.'); // Affiche un message générique à l'utilisateur
}

?>

<!-- Formulaire de recherche -->
<div class="container mt-3">
    <form action="" method="GET" class="form-inline justify-content-center">
        <!-- Champ de saisie pour la recherche, affichant le terme de recherche actuel -->
        <input type="text" name="search" class="form-control mr-sm-2" placeholder="Rechercher..." value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>">
        <!-- Bouton de soumission du formulaire -->
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
</div>

<!-- Affichage des catégories -->
<h2 class="text-center mt-5">Catégories les plus populaires</h2><br>
<div class="row no-gutters justify-content-center">
    <?php foreach ($categories as $i => $category) { ?>
        <?php 
        // Filtrage des catégories en fonction du terme de recherche
        if (stripos($category['libelle'], $searchTerm) !== false) { 
        ?>
            <?php 
            // Gestion de l'affichage en colonnes de 3 éléments
            if ($i % 3 == 0 && $i != 0) { 
            ?>
                </div><div class="row justify-content-center">
            <?php } ?>
            <div class="col-md-2 d-flex">
                <div class="card custom-card">
                    <!-- Affichage de l'image de la catégorie avec validation du chemin pour éviter les injections -->
                    <img src="<?php echo htmlspecialchars('images_the_district  (1)/cate/' . $category['image'], ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($category['libelle'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="card-body">
                        <!-- Affichage du nom de la catégorie -->
                        <h5 class="card-title"><?php echo htmlspecialchars($category['libelle'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <!-- Lien vers la page de détails de la catégorie -->
                        <a href="categorie.php?id=<?php echo $category['id']; ?>" class="btn btn-primary">Voir Catégorie</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<!-- Affichage des plats -->
<h2 class="text-center mt-5">Nos Plats Populaires</h2><br>
<div class="row no-gutters justify-content-center">
    <?php foreach ($plats as $i => $plat) { ?>
        <?php 
        // Filtrage des plats en fonction du terme de recherche
        if (stripos($plat['libelle'], $searchTerm) !== false) { 
        ?>
            <?php 
            // Gestion de l'affichage en colonnes de 3 éléments
            if ($i % 3 == 0 && $i != 0) { 
            ?>
                </div><div class="row justify-content-center">
            <?php } ?>
            <div class="col-md-2 d-flex">
                <div class="card custom-card">
                    <!-- Affichage de l'image du plat avec validation du chemin pour éviter les injections -->
                    <img src="<?php echo htmlspecialchars('images_the_district  (1)/food/' . $plat['image'], ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($plat['libelle'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="card-body">
                        <!-- Affichage du nom du plat -->
                        <h5 class="card-title"><?php echo htmlspecialchars($plat['libelle'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <!-- Lien vers la page de détails du plat -->
                        <a href="plat.php?id=<?php echo urlencode($plat['id']); ?>" class="btn btn-primary">Voir Plat</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<?php
// Déconnexion de la base de données (non nécessaire pour PDO, mais bonne pratique pour les ressources)
$pdo = null;

// Inclusion du footer
include 'footer.php'; // Assure-toi que ce fichier est sécurisé contre les inclusions malveillantes
?>
