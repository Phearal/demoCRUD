<?php
session_start();
require_once './config/config.php';
if (!(isset($_SESSION["id_utilisateur"]) && $_SESSION['role'] == 'administrateur')) {
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
    <script defer src="<?= JS ?>main.js"></script>
    <title><?= TITLE ?>Admin</title>
</head>

<body>
    <?php require_once TEMPLATE_PARTS . '_header.php'; ?>
    <div class="container">
        <h1 class="mb-5 mt-5">Page admin</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Évènements</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Lieux</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Utilisateurs</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <a href="./creerEvenement.php"><button type="button" class="btn btn-primary mt-5 mb-5">Ajouter un évènement</button></a>
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
                        $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto_evenements", "toto");
                        $stmtUser = $cnx->prepare("SELECT * FROM `evenements_utilisateurs_lieux` ORDER BY `evenements_utilisateurs_lieux`.`id_evenement` DESC");
                        $stmtUser->execute();
                        $evenements = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($evenements as $evenement) :
                        ?>
                            <tr>
                                <th scope="row"><?= $evenement["id_evenement"] ?></th>
                                <td><?= $evenement['nom'] ?></td>
                                <td><?= $evenement['lieux'] ?></td>
                                <td><?= $evenement['date'] ?></td>
                                <td><?= $evenement['nb_places'] ?></td>
                                <td>
                                    <i type="button" class="bi bi-trash-fill trashEvent" data-id="<?= $evenement["id_evenement"] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" style="color: #000;"></i>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <a href="./creerLieu.php"><button type="button" class="btn btn-primary mt-5 mb-5">Ajouter un lieu</button></a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Code postal</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmtLieu = $cnx->prepare("SELECT * FROM `lieu` ORDER BY `id_lieu` DESC");
                        $stmtLieu->execute();
                        $lieux = $stmtLieu->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($lieux as $lieu) :
                        ?>
                            <tr>
                                <th scope="row"><?= $lieu["id_lieu"] ?></th>
                                <td><?= $lieu['nom'] ?></td>
                                <td><?= $lieu['adresse'] ?></td>
                                <td><?= $lieu['ville'] ?></td>
                                <td><?= $lieu['CP'] ?></td>
                                <td>
                                    <i type="button" class="bi bi-trash-fill trashPlace" data-id="<?= $lieu["id_lieu"] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" style="color: #000;"></i>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rôle</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmtUtilisateur = $cnx->prepare("SELECT * FROM `utilisateur` ORDER BY `id_utilisateur` DESC");
                        $stmtUtilisateur->execute();
                        $utilisateurs= $stmtUtilisateur->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($utilisateurs as $utilisateur) :
                        ?>
                            <tr>
                                <th scope="row"><?= $utilisateur["id_utilisateur"] ?></th>
                                <td><?= $utilisateur['nom'] ?></td>
                                <td><?= $utilisateur['prenom'] ?></td>
                                <td><?= $utilisateur['email'] ?></td>
                                <td><?= $utilisateur['role'] ?></td>
                                <td>
                                    <i type="button" class="bi bi-trash-fill trashPlace" data-id="<?= $utilisateur["id_utilisateur"] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" style="color: #000;"></i>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
        </div>
    </div>

    <!-- Modal delete event -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 modalTitle" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="modalText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a id="deleteContentBtn" href="">
                        <button type="button" class="btn btn-primary">Valider</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>