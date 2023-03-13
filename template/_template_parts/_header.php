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
                    <a class="nav-link active" aria-current="page" href="index.php">Évènements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Nous contacter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aPropos.php">À propos</a>
                </li>
            </ul>

        <div>
            <i type="button" class="bi bi-person-fill dropdown-toggle" style="font-size: 2rem; color: #fff;" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php if(isset($_SESSION["id_utilisateur"])): ?>
                    <li><a class="dropdown-item" href="./compte.php">Mon compte</a></li>
                    <li><a class="dropdown-item" href="./deconnexion.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a class="dropdown-item" href="./connexion.php">Connexion</a></li>
                    <li><a class="dropdown-item" href="./inscription.php">Créer un compte</a></li>
                <?php endif ?>
            </ul>
        </div>

    </div>
    </div>
    </nav>
</header>