<?php
session_start();
require_once './config/config.php';
if (!(isset($_SESSION["id_utilisateur"]) && $_SESSION['role'] == 'administrateur')) {
    header('location:connexion.php');
}
$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto", "toto");
$stmtEvent = $cnx->prepare("SELECT * FROM utilisateur WHERE id_utilisateur= :id_utilisateur");
$stmtEvent->bindParam(':id_utilisateur', $_GET['id']);
$stmtEvent->execute();
$utilisateur = $stmtEvent->fetch(PDO::FETCH_ASSOC);

if(!$utilisateur){
    header('admin.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= FAVICON ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_ICONS ?>">
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Edit utilisateur n°<?= $utilisateur['id_utilisateur'] ?></title>
</head>

<body>
    <div class="mb-5"></div>
    <a href="./admin.php"><i class="bi bi-chevron-double-left p-2"></i>Retour au menu admin</a>
    <main>
        <div class="container">
            <h1 class="mb-5 mt-5">Modifier l'utilisateur</h1>

            <form action="editUser.php?id=<?= $utilisateur['id_utilisateur'] ?>" method="post">
                <div class="row">
                    <div class="col mb-3">
                        <label for="prenom" class="form-label">Nom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= $utilisateur['prenom'] ?>">
                    </div>
                    <div class="col mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= $utilisateur['nom'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $utilisateur['email'] ?>">
                    </div>
                    <div class="col mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" name="mdp" class="form-control" value="<?= $utilisateur['mdp'] ?>">
                    </div>
                </div>
                <div class="mb-3">
                <label for="roleSelect" class="form-label">Role</label>
                    <select class="form-select" aria-label="Default select example" name="roleSelect">
                        <option selected><?= $utilisateur['role'] ?></option>
                        <?php foreach (ROLES as $role) : ?>
                            <option value="<?= $role ?>"><?= $role ?></option>
                            <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="submit" value="Enregistrer" class="btn btn-primary">
                </div>
            </form>

        </div>
    </main>
</body>
</html>