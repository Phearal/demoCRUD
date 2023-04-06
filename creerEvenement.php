<?php
session_start();
require_once './config/config.php';
if (!(isset($_SESSION["id_utilisateur"]) && $_SESSION['role'] == 'administrateur')) {
    header('location:connexion.php');
}
require_once('createEvent.php');
$stmtLieux = $cnx->prepare("SELECT nom FROM lieu");
$stmtLieux->execute();
$lieux = $stmtLieux->fetchAll(PDO::FETCH_ASSOC);
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
            <h1 class="mb-5 mt-5">Nouvel évènement</h1>
            <?php if (isset($_SESSION['erreurlieuAbsent'])) : ?>
                <div class="d-flex flex-row mb-3">
                    <i class="bi bi-exclamation-circle me-2 text-danger" fill="red"></i>
                    <p class="error text-danger"><?= $_SESSION['erreurlieuAbsent']; ?></p>
                </div>
            <?php
                $_SESSION['erreurlieuAbsent'] = NULL;
            endif
            ?>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control">
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nb_places" class="form-label">Nombre de places</label>
                        <input type="number" name="nb_places" class="form-control">
                    </div>
                    <div class="col mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleDataList" class="form-label">Lieu</label>
                    <input name="lieu" class="form-control" list="lieux" id="exampleDataList" placeholder="Type to search...">
                    <datalist id="lieux">
                        <?php foreach ($lieux as $lieu) : ?>
                            <option value="<?= $lieu['nom'] ?>">
                            <?php endforeach ?>
                    </datalist>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" aria-label="With textarea"></textarea>
                </div>
                <div class="mb-3">
                    <?php if (!empty($formError)) : ?>
                        <div style="color:red;">
                            <?php foreach ($formError as $error) : ?>
                                <div><?= $error ?></div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <label class="form-label" for="img_cover">Image</label>
                    <input name="img_cover" type="file" class="form-control" id="img_cover">
                </div>
                <div class="mb-3">
                    <input type="submit" name="submit" value="Enregistrer" class="btn btn-primary">
                </div>
            </form>

        </div>
    </main>
</body>

</html>