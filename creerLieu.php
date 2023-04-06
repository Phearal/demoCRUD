<?php
session_start();
require_once './config/config.php';
if (!(isset($_SESSION["id_utilisateur"]) && $_SESSION['role'] == 'administrateur')) {
    header('location:connexion.php');
}
$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto", "toto");
$stmt = $cnx->prepare("SELECT nom FROM lieu");
$stmt->execute();
$lieux = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= FAVICON ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_ICONS ?>">
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Inscription</title>
</head>

<body>
    <div class="mb-5"></div>
    <a href="./admin.php"><i class="bi bi-chevron-double-left p-2"></i>Retour au menu admin</a>
    <main>
        <div class="container">
            <h1 class="mb-5 mt-5">Nouveau lieu</h1>
            <?php if (isset($_SESSION['erreurLieuExistant'])) : ?>
                <div class="d-flex flex-row mb-3">
                    <i class="bi bi-exclamation-circle me-2 text-danger" fill="red"></i>
                    <p class="error text-danger"><?= $_SESSION['erreurLieuExistant']; ?></p>
                </div>
            <?php
                $_SESSION['erreurLieuExistant'] = NULL;
            endif
            ?>

            <form action="createPlace.php" method="post">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" name="adresse" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" name="ville" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="CP" class="form-label">Code postal</label>
                    <input type="text" name="CP" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                </div>
            </form>

        </div>
    </main>
</body>

</html>