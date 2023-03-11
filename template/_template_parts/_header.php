<header>
    <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">E-Vents |</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="evenements.php">Évènements</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="contact.php">Nous contacter</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="aPropos.php">À propos</a>
            </li>
        </ul>
        <span class="navbar-text">
            <?php if(isset($_SESSION["id_utilisateur"])): ?>
                <a class="nav-link" href="./deconnexion.php">Déconnexion</a>
            <?php else: ?>
                <a class="nav-link" href="./connexion.php">Connexion</a>
            <?php endif ?>
            <a class="nav-link" href="inscription.php">Inscription</a>
        </span>
        </div>
    </div>
    </nav>
</header>