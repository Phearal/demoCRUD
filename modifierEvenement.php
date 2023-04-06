<?php
session_start();
require_once './config/config.php';
if (!(isset($_SESSION["id_utilisateur"]) && $_SESSION['role'] == 'administrateur')) {
    header('location:connexion.php');
}
$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto", "toto");
$stmtEvent = $cnx->prepare("SELECT * FROM evenement WHERE id_evenement= :id_evenement");
$stmtEvent->bindParam(':id_evenement', $_GET['id']);
$stmtEvent->execute();
$evenement = $stmtEvent->fetch(PDO::FETCH_ASSOC);

$stmtLieu = $cnx->prepare("SELECT nom FROM lieu WHERE id_lieu= :id_lieu");
$stmtLieu->bindParam(':id_lieu', $evenement['id_lieu']);
$stmtLieu->execute();
$lieu = $stmtLieu->fetch(PDO::FETCH_ASSOC);

$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto", "toto");
$stmtLieux = $cnx->prepare("SELECT nom FROM lieu");
$stmtLieux->execute();
$lieux = $stmtLieux->fetchAll(PDO::FETCH_ASSOC);

if(!$evenement){
    header('admin.php');
}
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
    <title><?= TITLE ?>Edit évènement n°<?= $evenement['id_evenement'] ?></title>
</head>

<body>
    <div class="mb-5"></div>
    <a href="./admin.php"><i class="bi bi-chevron-double-left p-2"></i>Retour au menu admin</a>
    <main>
        <div class="container">
            <h1 class="mb-5 mt-5">Modifier l'évènement</h1>
            <?php if (isset($_SESSION['erreurlieuAbsent'])) : ?>
                <div class="d-flex flex-row mb-3">
                    <i class="bi bi-exclamation-circle me-2 text-danger" fill="red"></i>
                    <p class="error text-danger"><?= $_SESSION['erreurlieuAbsent']; ?></p>
                </div>
            <?php
                $_SESSION['erreurlieuAbsent'] = NULL;
                endif
            ?>

            <form action="editEvent.php?id=<?= $evenement['id_evenement'] ?>" method="post">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" value="<?= $evenement['nom'] ?>">
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nb_places" class="form-label">Nombre de places</label>
                        <input type="number" name="nb_places" class="form-control" value="<?= $evenement['nb_places'] ?>">
                    </div>
                    <div class="col mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="<?= $evenement['date'] ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleDataList" class="form-label">Lieu</label>
                    <input name="lieu" class="form-control" list="lieux" id="exampleDataList" placeholder="Type to search..." value="<?= $lieu['nom'] ?>">
                    <datalist id="lieux">
                        <?php foreach ($lieux as $lieu) : ?>
                            <option value="<?= $lieu['nom'] ?>">
                            <?php endforeach ?>
                    </datalist>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" aria-label="With textarea"><?= $evenement['description'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="img_cover">Image (conservera l'image actuelle si laissé vide)</label>
                    <input name="img_cover" type="file" class="form-control" id="img_cover" value="<?= $evenement['img_cover'] ?>">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                </div>
            </form>

        </div>
    </main>
</body>
</html>