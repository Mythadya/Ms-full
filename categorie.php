<?php
// Incluez la classe DAO (Data Access Object)
include 'DAO.php';

// Incluez le fichier d'en-tête
include 'header.php';

// Définissez les paramètres de connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=District';
$username = 'admin';
$password = 'Afpa1234';

try {
    // Créez une nouvelle instance PDO avec les paramètres de connexion
    $pdo = new PDO($dsn, $username, $password);
    
    // Définissez le mode d'erreur sur les exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créez une nouvelle instance de la classe DAO, en passant l'instance PDO
    $categoryDAO = new DAO($pdo);

    // Récupérez les catégories actives de la base de données à l'aide de la DAO
    $categories = $categoryDAO->getActiveCategories();
} catch (PDOException $e) {
    // Attrapez les exceptions PDO et affichez un message d'erreur
    echo "Connexion échouée : ". $e->getMessage();
    die();
}
?>

<!-- Le contenu HTML commence ici -->

<h2 class="text-center mt-5">Les Catégories </h2><br>

<!-- Créez une rangée pour afficher les catégories -->
<div class="row no-gutters justify-content-center">
    <?php foreach ($categories as $i => $category) {?>
        <?php if ($i % 3 == 0 && $i!= 0) {?>
            <!-- Fermez la rangée actuelle et commencez une nouvelle rangée toutes les 3 catégories -->
            </div><div class="row justify-content-center">
        <?php }?>
        <!-- Affichez chaque catégorie comme une carte -->
        <div class="col-md-2 d-flex">
            <div class="card custom-card">
                <!-- Affichez l'image de la catégorie -->
                <img src="<?php echo 'images_the_district  (1)/cate/'. $category['image'];?>" class="card-img-top" alt="<?php echo $category['libelle'];?>">
                <div class="card-body">
                    <!-- Affichez le titre de la catégorie -->
                    <h5 class="card-title"><?php echo $category['libelle'];?></h5>
                    <!-- Créez un lien vers la page de la catégorie -->
                    <a href="category.php?id=<?php echo $category['id'];?>" class="btn btn-primary">Voir Catégorie</a>
                </div>
            </div>
        </div>
    <?php }?>
</div>

<?php
// Fermez la connexion PDO
$pdo = null;

// Incluez le fichier de pied de page
include 'footer.php';
?>