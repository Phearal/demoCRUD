<?php
    session_start();
    include_once './config/config.php'
?>
<!--
<?php if(isset($_SESSION["id_utilisateur"])): ?>
    <div>
        Bonjour <?= $_SESSION['prenom']; ?>
        <br><a href="./deconnexion.php">Déconnexion</a>
    </div>
<?php else: ?>
    <div>
        <a href="./connexion.php">Connexion</a>
    </div>
<?php endif ?>
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <!-- <link rel="stylesheet" href="<?= CSS ?>style.css">
    <link rel="stylesheet" href="<?= CSS ?>accueil.css"> -->
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <!-- <script defer src="<?= JS ?>main.js"></script> -->
    <title><?= TITLE ?> | Accueil</title>
</head>
<body>
    <?php require_once TEMPLATE_PARTS . '_header.php';?>

    <h1>Gestion des évènements</h1>
    <nav>
        <ul>
            <li><a href="./index.php">Accueil</a></li>
            <li><a href="./inscription.php">Inscription</a></li>
        </ul>
    </nav>
    <hr>
    <main>
        <div class="container">
            <h2>Liste des évènements</h2>
            <?php
                $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto_evenements","toto");
                // var_dump($cnx);
                $stmt = $cnx->prepare("SELECT * FROM evenement");
                $stmt->execute();
                $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($evenements as $evenement):
            ?>
                <div class="row mb-5">
                    <div class="col">
                        <img src="<?= $evenement['img_cover'] ?>" alt="">
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
                            <a href="#" class="btn btn-success" role="button"">M'inscrire</a>
                            <a href="detailsEvenement.php?id=<?= $evenement["id_evenement"] ?>" class="btn btn-secondary" role="button"">Voir en détail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>