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
    <link rel="stylesheet" href="<?= CSS ?>style.css">
    <link rel="stylesheet" href="<?= BOOTSTRAP_ICONS ?>">
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Évènement n°<?= $_GET["id"] ?></title>
</head>
<body>
    <?php require_once TEMPLATE_PARTS . '_header.php';?>
    <?php
        // On récupère le paramètre d'URL id
        $id = $_GET["id"];
        // Connexion à la BDD
        try {
            $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto_evenements","toto");
        } catch(Exception $e) {
            echo "Connexion à la BDD impossible !";
        }
        // Requête préparée avec un paramètre
        // !!! Ne pas mettre $id dans la requête SQL !!!
        $stmt = $cnx->prepare("SELECT * FROM evenements_utilisateurs_lieux WHERE id_evenement= :id");
        // On indique les paramètres
        $stmt->bindParam(":id", $id);
        // Exécution de la requête
        $stmt->execute();
        // On utilise fetch et pas fetchAll car on s'attend à récupérer un seul enregistrement
        $evenement = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="container">
            <?php if (!empty($evenement)) :
            ?>
                <div class="row mb-5 mt-5">
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
                        <p>Lieu : <?= $evenement['lieux'] ?></p>             
                        <p>Nombre de places : <?= $evenement['nb_places'] ?></p>
                        <p>Organisateur : <?= $evenement['organisateur'] ?></p>
                        <?php
                                $stmtInscription = $cnx->prepare("SELECT * FROM `utilisateur_evenement` WHERE id_evenement = :id_evenement AND id_utilisateur = :id_utilisateur");
                                $stmtInscription->bindParam(':id_evenement', $evenement["id_evenement"]);
                                $stmtInscription->bindParam(':id_utilisateur', $_SESSION["id_utilisateur"]);
                                $stmtInscription->execute();
                                $inscription = $stmtInscription->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="justify-content-between">                           
                                <?php if($inscription): ?>
                                    <a href="./eventUnsubscribe.php?idEvent=<?= $evenement["id_evenement"] ?>" class="btn btn-danger" role="button">Me désinscrire</a>
                                <?php else: ?>
                                    <a href="
                                    <?php if(!isset($_SESSION["id_utilisateur"])): ?>
                                        ./connexion.php
                                    <?php else: ?>
                                        ./eventRegistration.php?idEvent=<?= $evenement["id_evenement"] ?>
                                    <?php endif ?>
                                    " class="btn btn-success" role="button">M'inscrire</a>
                                <?php endif ?>
                            </div>
                    </div>
                </div>
                
            <?php else : ?>
                <p>L'évènement <?= $id ?> n'existe pas.</p>
            <?php endif ?>
        </div>
</body>
</html>