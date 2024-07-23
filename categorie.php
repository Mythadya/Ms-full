<?php
include 'DAO.php';
include 'header.php';

$dsn = 'mysql:host=localhost;dbname=District';
$username = 'admin';
$password = 'Afpa1234';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $categoryDAO = new DAO($pdo);

    $categories = $categoryDAO->getActiveCategories();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
<h2 class="text-center mt-5">Les Catégories </h2><br>
<div class="row no-gutters justify-content-center">
    <?php foreach ($categories as $i => $category) { ?>
        <?php if ($i % 3 == 0 && $i != 0) { ?>
            </div><div class="row justify-content-center">
        <?php } ?>
        <div class="col-md-2 d-flex">
            <div class="card custom-card">
                <img src="<?php echo 'images_the_district  (1)/cate/' . $category['image']; ?>" class="card-img-top" alt="<?php echo $category['libelle']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $category['libelle']; ?></h5>
                    <a href="category.php?id=<?php echo $category['id']; ?>" class="btn btn-primary">Voir Catégorie</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
$pdo = null;

include 'footer.php';
?>
