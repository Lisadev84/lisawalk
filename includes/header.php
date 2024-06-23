<?php
require_once "head.php";
?>
<title><?= $title ?? "Lisawalk" ?></title>


<body>
    <header>
        <div id="logo">
            <img src="/images/LisaWalk.png" alt="logo LisaWalk">
        </div>
        <div class="navbar">
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <?php if (isset($_SESSION['user'])) : ?>

                        <li><a class="menu">Randonnées ▼</a>
                            <ul class="down">
                                <li><a href="vaucluse.php">Vaucluse</a></li>
                                <li><a href="gard.php">Gard</a></li>
                                <li><a href="drome.php">Drôme</a></li>
                                <li><a href="bdr.php">Bouches-du-Rhône</a></li>
                                <li><a href="france.php">Ailleurs en France</a></li>
                            </ul>
                        <?php endif; ?>
                        </li>
                        <li><a class="menu">Membres ▼</a>
                            <ul class="down">
                                <?php if (!isset($_SESSION["user"])) : ?>
                                    <li><a href="inscription.php">Inscription</a></li>
                                    <li><a href="auth.php">connexion</a></li>

                                <?php else : ?>
                                    <li><a href="profil.php">Profil</a></li>
                                    <li><a href="deconnexion.php">Déconnexion</a></li>
                                    <li><a href="desinscription.php">Désinscription</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li><a href="livredor.php">Livre d'Or</a></li>
                        <?php if (isset($_SESSION["user"]) && ($_SESSION['user']['role'] === 'role_admin')) : ?>
                            <li><a href="/../Admin/admin.php">Administration</a></li>
                        <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>