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
    <link rel="shortcut icon" href="<?= FAVICON ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_ICONS ?>">
    <link rel="stylesheet" href="<?= CSS ?>style.css">
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <script defer src="<?= JS ?>main.js"></script>
    <script defer src="<?= JS ?>eventFilter.js"></script>
    <title><?= TITLE ?>Accueil</title>
</head>

<body>
    <?php require_once TEMPLATE_PARTS . '_header.php'; ?>

    <main>
        <div class="container">

            <h1 class="mb-5 mt-5">Liste des évènements</h1>

            <div class="mb-5">
                <div class="row">
                    <div class="col">
                        Mot clé :
                        <form class="d-flex mt-2" role="search">
                            <input class="form-control me-2" type="search" id="searchBar" placeholder="Recherche" aria-label="Search">
                            <button class="btn btn-outline-success" id="searchBtn" type="submit">Recherche</button>
                        </form>
                    </div>
                    <div class="col">
                        Ordre alphabétique :
                        <select class="form-select mt-2" aria-label="Default select example" id="selectAO">
                            <option selected>-- Choisir --</option>
                            <option value="1">A à Z</option>
                            <option value="2">Z à A</option>
                        </select>
                    </div>
                    <div class="col">
                        Date :
                        <select class="form-select mt-2" aria-label="Default select example" id="selectDate">
                            <option selected>-- Choisir --</option>
                            <option value="1">Les + proches d'abord</option>
                            <option value="2">Les - proches d'abord</option>
                        </select>
                    </div>

                </div>
            </div>

            <div id="eventsContainer">
                <?php
                $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto_evenements", "toto");
                $stmt = $cnx->prepare("SELECT * FROM evenement");
                $stmt->execute();
                $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($evenements as $evenement) :
                ?>
                    <div class="row mb-5 event">
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
                            <?php
                            $stmtInscription = $cnx->prepare("SELECT * FROM `utilisateur_evenement` WHERE id_evenement = :id_evenement AND id_utilisateur = :id_utilisateur");
                            $stmtInscription->bindParam(':id_evenement', $evenement["id_evenement"]);
                            $stmtInscription->bindParam(':id_utilisateur', $_SESSION["id_utilisateur"]);
                            $stmtInscription->execute();
                            $inscription = $stmtInscription->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="justify-content-between">
                                <?php if ($inscription) : ?>
                                    <a href="./eventUnsubscribe.php?idEvent=<?= $evenement["id_evenement"] ?>" class="btn btn-danger" role="button">Me désinscrire</a>
                                <?php else : ?>
                                    <a href="
                                        <?php if (!isset($_SESSION["id_utilisateur"])) : ?>
                                            ./connexion.php
                                        <?php else : ?>
                                            ./eventRegistration.php?idEvent=<?= $evenement["id_evenement"] ?>
                                        <?php endif ?>
                                        " class="btn btn-success" role="button">M'inscrire</a>
                                <?php endif ?>
                                <a href=" detailsEvenement.php?id=<?= $evenement["id_evenement"] ?>" class="btn btn-secondary" role="button"">Voir en détail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </main>
</body>

</html>