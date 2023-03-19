<?php
session_start();
require_once './config/config.php';
if(!(isset($_SESSION["id_utilisateur"]))) {
    header('location:connexion.php');
}
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
    <title><?= TITLE ?>Mon compte</title>
</head>

<body>
    <?php
        require_once TEMPLATE_PARTS . '_header.php';
        $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto_evenements", "toto");
    ?>

    <main>
        <div class="container">
            <h1 class="mb-2 mt-5">Mon compte</h1>
            <?php
                $stmtUserInfo = $cnx->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
                $stmtUserInfo->bindParam(':id_utilisateur', $_SESSION["id_utilisateur"]);
                $stmtUserInfo->execute();
                $userInfo = $stmtUserInfo->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="fs-5">Nom : <?= $userInfo['nom'] ?></p>
            <p class="fs-5">Prénom : <?= $userInfo['prenom'] ?></p>
            <p class="fs-5">Email : <?= $userInfo['email'] ?></p>
            <p class="fs-5">Rôle : <?= $userInfo['role'] ?></p>

            <div>
                <h2 class="mt-5 mb-2">Mes évènements :</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Lieu</th>
                            <th scope="col">Date</th>
                            <th scope="col">Nb places</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmtUserEvent = $cnx->prepare("SELECT * FROM utilisateur_evenement WHERE id_utilisateur = :id_utilisateur");
                        $stmtUserEvent->bindParam(":id_utilisateur", $_SESSION["id_utilisateur"]);
                        $stmtUserEvent->execute();
                        $userEvents = $stmtUserEvent->fetchAll(PDO::FETCH_ASSOC);

                        if(count($userEvents) > 0) {
                            for ($i = 0; $i < count($userEvents); $i++) {
                                $stmtEvent = $cnx->prepare("SELECT * FROM `evenements_utilisateurs_lieux` WHERE id_evenement = :id_evenement");
                                $stmtEvent->bindParam("id_evenement", $userEvents[$i]["id_evenement"]);
                                $stmtEvent->execute();
                                $evenement = $stmtEvent->fetch(PDO::FETCH_ASSOC);
                                
                                if($evenement) { ?>
                                    <tr>
                                    <th scope="row"><?= $evenement["id_evenement"] ?></th>
                                    <td><?= $evenement['nom'] ?></td>
                                    <td><?= $evenement['lieux'] ?></td>
                                    <td><?= $evenement['date'] ?></td>
                                    <td><?= $evenement['nb_places'] ?></td>
                                    <td>
                                    <a href="./detailsEvenement.php?id=<?= $evenement["id_evenement"] ?>">Détails</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                        } else {
                            echo("Vous n'êtes inscrit à aucun évènement !");
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>