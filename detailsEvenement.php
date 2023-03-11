<?php
    session_start();
    include_once './config/config.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Évènement n°<?= $_GET["id"] ?></title>
</head>
<body>
    <?php require_once TEMPLATE_PARTS . '_header.php';?>
    <?php
        // On récupère le paramètre d'URL id
        $id = $_GET["id"];
        var_dump($id);
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
                        <p>Lieu : <?= $evenement['lieux'] ?></p>             
                        <p>Nombre de places : <?= $evenement['nb_places'] ?></p>
                        <p>Organisateur : <?= $evenement['organisateur'] ?></p>
                        <div class="justify-content-between">
                            <a href="#" class="btn btn-success" role="button"">M'inscrire</a>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>L'évènement <?= $id ?> n'existe pas.</p>
            <?php endif ?>
        </div>
</body>
</html>