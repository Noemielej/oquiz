<nav>
    <div class="float-left">
        <h1>O'Quiz</h1>
    </div>

    <ul class="nav nav-pills justify-content-end mb-5">
        <!-- Si l'utilisateur est connecté alors on affiche son nom -->
        <?php if ($connectedUser !== false) : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('users_compte') ?>">
                    Bonjour <?= $connectedUser->getFirstName() ?>
                </a>
            </li>
        <!-- Sinon on affiche ce qui suit -->
        <?php endif ; ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('main_home') ?>">
                <i class="fa fa-home"></i>
                &nbsp;Accueil
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= $router->generate('users_compte') ?>">
                <i class="fas fa-user"></i>
                &nbsp;Mon compte
            </a>
        </li>
        <!-- Si l'utilisateur est connecté alors il peut ce déconnecter -->
        <?php if ($connectedUser !== false) : ?>
            <li class="nav-item">
                <a class="nav-link " href="<?= $router->generate('users_logout')?>">
                    <i class="fas fa-sign-out-alt"></i>
                    &nbsp;Déconnexion
                </a>
            </li>
        <!-- Sinon il peut ce connecter -->
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link " href="<?= $router->generate('users_signin')?>">
                    <i class="fas fa-sign-in-alt"></i>
                    &nbsp;Connexion
                </a>
            </li>
        <?php endif ; ?>
    </ul>
</nav>
