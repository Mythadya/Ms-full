<?php
include 'DAO.php'; // Inclusion du fichier contenant la classe DAO
include 'header.php'; // Inclusion du fichier d'en-tête HTML

// Connexion à la base de données
try {
    // Utilisation des variables d'environnement pour les informations sensibles
    $dsn = getenv('DB_DSN') ?: 'mysql:host=localhost;dbname=District';
    $username = getenv('DB_USERNAME') ?: 'admin';
    $password = getenv('DB_PASSWORD') ?: 'Afpa1234';

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    error_log('Database connection error: ' . $e->getMessage());
    die('Unable to connect to the database.');
}

$categoryDAO = new DAO($pdo); // Création d'une instance de la classe DAO avec la connexion PDO

// Récupération des catégories et des plats depuis la base de données
try {
    $categories = $categoryDAO->getCategories();
    $plats = $categoryDAO->getPlats();
} catch (Exception $e) {
    error_log('Data retrieval error: ' . $e->getMessage());
    die('Unable to retrieve data.');
}

// Récupération et validation des informations du plat
$plat_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;
$plat_libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING) ?: '';
$plat_prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT) ?: 0.0;
$plat_image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING) ?: '';

// Protection contre les attaques CSRF
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>

<main>
    <div id="form-container" class="container2">
        <h1 class="text-center" style="color: #FFFFFF;">Formulaire de Commande</h1><br>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($plat_image); ?>" alt="<?php echo htmlspecialchars($plat_libelle); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($plat_libelle); ?></h5>
                        <p class="card-text">Prix : <?php echo htmlspecialchars($plat_prix); ?> €</p>
                        <div class="input-group">
                            <button class="btn btn-outline-primary" type="button" id="decreaseQuantity">-</button>
                            <input type="text" class="form-control text-center" id="quantityInput" value="1" readonly>
                            <button class="btn btn-outline-primary" type="button" id="increaseQuantity">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center">
            <form id="contactForm" novalidate method="post" action="process_order.php">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <div class="row mb-3 needs-validation">
                    <div class="col"><br>
                        <label for="nometprenom" class="form-label" style="color: #FFFFFF;">Nom et Prenom*</label>
                        <input type="text" class="form-control" id="nometprenom" name="nometprenom" required>
                        <div class="valid-feedback">Looks good!</div>
                        <small class="text-danger validation-message">*Ce champ est obligatoire</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="email" class="form-label" style="color: #FFFFFF;">Email*</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="valid-feedback">Looks good!</div>
                        <small class="text-danger validation-message">*Ce champ est obligatoire</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="telephone" class="form-label" style="color: #FFFFFF;">Téléphone*</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                        <div class="valid-feedback">Looks good!</div>
                        <small class="text-danger validation-message">*Ce champ est obligatoire</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="adresse" class="form-label" style="color: #FFFFFF;">Adresse*</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                        <div class="valid-feedback">Looks good!</div>
                        <small class="text-danger validation-message">*Ce champ est obligatoire</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="ville" class="form-label" style="color: #FFFFFF;">Ville*</label>
                        <input type="text" class="form-control" id="ville" name="ville" required>
                        <div class="valid-feedback">Looks good!</div>
                        <small class="text-danger validation-message">*Ce champ est obligatoire</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                    <label for="codepostal" class="form-label" style="color: #FFFFFF;">Code Postal*</label>
                        <input type="text" class="form-control" id="codepostal" name="codepostal" required>
                        <div class="valid-feedback">Looks good!</div>
                        <small class="text-danger validation-message">*Ce champ est obligatoire</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="commentaire" class="form-label" style="color: #FFFFFF;">Commentaire</label>
                        <textarea class="form-control" id="commentaire" name="commentaire"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Valider la commande</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Inclusion de Bootstrap JS et du fichier script.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

<?php
include 'footer.php';
?>
