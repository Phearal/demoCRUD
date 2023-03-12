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
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Inscription</title>
</head>
<body>
    <main>
        <h1>Inscription</h1>
        <!-- Si Email existe déjà -->
        <?php if(isset($_SESSION['erreurEmailExistant'])): ?>
            <p class="error"><?= $_SESSION['erreurEmailExistant']; ?></p>
        <?php
            session_destroy();
            endif
        ?>

        <form action="register.php" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control">
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
                </div>
            <div class="mb-3">
                <label for="mdp" class="form-label">Mot de passe</label>
                <input type="password" name="mdp" class="form-control">
            </div>
            <div class="mb-3">
                <input type="submit" value="Enregistrer" class="btn btn-primary">
            </div>
        </form>
        <p>Vous avez déjà un compte ?</p>
        <a href="./connexion.php">Se connecter</a>
    </main>
</body>
</html>