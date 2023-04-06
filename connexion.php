<?php
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
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <title><?= TITLE ?>Connexion</title>
</head>
<body>
    <div class="mb-5"></div>
    <a href="./index.php"><i class="bi bi-chevron-double-left p-2"></i>Retour à l'accueil</a>
    <main>
        <div class="container">
            <h1 class="mb-5 mt-5">Connexion</h1>
            <form action="signIn.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                    </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="submit" value="Connexion" class="btn btn-primary">
                </div>
            </form>
            <div class="d-flex flex-column align-items-center mt-5">
                <p>Vous n'avez pas de compte ?</p>
                <a href="./inscription.php">Créez en un ici</a>
            </div>
        </div>


    </main>
</body>
</html>