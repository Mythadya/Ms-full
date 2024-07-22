<?php
require_once 'DAO.php';
include 'header.php';

$dsn = 'mysql:host=localhost;dbname=District';
$username = 'admin';
$password = 'Afpa1234';


$pdo = new PDO($dsn, $username, $password);


$categoryDAO = new DAO($pdo);


$categories = $categoryDAO->getCategories();


?>
<h2 class="text-center mt-5">catégories les plus populaires </h2><br>
<div class="row  no-gutters justify-content-center">
    <?php foreach ($categories as $i => $category) { ?>
        <?php if ($i % 3 == 0 && $i != 0) { ?>
            </div><div class="row justify-content-center">
        <?php } ?>
        <div class="col-md-2 d-flex">
            <div class="card custom-card">
                <img src="<?php echo 'images_the_district  (1)/cate/' . $category['image'];?>" class="card-img-top" alt="<?php echo $category['libelle'];?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $category['libelle'];?></h5>
                    <a href="<?php echo $category['id'];?>" class="btn btn-primary">View Category</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
$pdo = null;

include 'footer.php';
?>