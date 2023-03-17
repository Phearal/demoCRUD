<?php
session_start();
require_once './config/config.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_ICONS ?>">
    <link rel="stylesheet" href="<?= CSS ?>style.css">
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Accueil</title>
</head>

<body>
    <?php require_once TEMPLATE_PARTS . '_header.php'; ?>

    <main>
        <div class="container">
            <h1 class="mb-5 mt-5">Liste des évènements</h1>
            <?php
            $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto_evenements", "toto");
            // var_dump($cnx);
            $stmt = $cnx->prepare("SELECT * FROM evenement");
            $stmt->execute();
            $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($evenements as $evenement) :
            ?>
                <div class="row mb-5">
                    <div class="col">
                        <img class="rounded" src="<?= $evenement['img_cover'] ?>" alt="">
                    </div>
                    <div class="col d-flex flex-column justify-content-between">
                        <div class="row">
                            <div class="col">
                                <h3><?= $evenement['nom'] ?></h3>
                            </div>
                            <div class="col">
                                <p>Date : <?= $evenement['date'] ?></p>
                            </div>
                        </div>
                        <p><?= $evenement['description'] ?></p>
                        <p>Nombre de places : <?= $evenement['nb_places'] ?></p>
                        <div class="justify-content-between">
                            <a href="
                                <?php if(!isset($_SESSION["id_utilisateur"])): ?>
                                    ./connexion.php
                                <?php else: ?>
                                    ./eventRegistration.php?idUser=<?= $_SESSION["id_utilisateur"] ?>&idEvent=<?= $evenement["id_evenement"] ?>
                                <?php endif ?>
                            " class="btn btn-success" role="button"">M'inscrire</a>
                            <a href=" detailsEvenement.php?id=<?= $evenement["id_evenement"] ?>" class="btn btn-secondary" role="button"">Voir en détail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>