<?php
namespace App;

session_start();
 if (isset($_SESSION["user"])) {
      header("Location: index.php");
   exit;
}

use App\Models\UsersModel;
use App\Autoloader;

require_once "Autoloader.php";
Autoloader::register();



$error = "";

if (!empty($_POST)) {
    if (
        isset($_POST["pseudo"], $_POST["pass"])
        && !empty($_POST["pseudo"]) && !empty($_POST["pass"])
    ) {
        $usersModel = new UsersModel;
        $userArray = $usersModel->findOneByPseudo(htmlspecialchars($_POST['pseudo']));

        if (!$userArray) {
            $error = "Identifiants incorrects.";
        } else {
            $user = $usersModel->hydrate($userArray);

            if (password_verify($_POST['pass'], $user->getPassword())) {
                $user->setSession();
                header("Location: index.php");
                exit;
            } else {
                $error = "Identifiants incorrects.";
            }
        }
    } else {
        $error = "Veuillez entrer vos identifiants.";
    }
}

$title = "Connexion";
include_once "includes/header.php";
?>

<section class="connexion">

    <h3>Connectez-vous</h3>

    <div class="auth">
        <form class="co" method="post">

            <div class="form-group">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="form-control">
            </div>
            <div class="form-group">
                <label for="pass" class="form-label">Mot de passe</label>
                <input type="password" name="pass" id="pass" class="form-control">
            </div>
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="submit">
                <button class="btn mt-3 mb-4" type="submit"> Connexion</button>
            </div>
        </form>

        <div class="subscribe">
            <h3>Pas encore inscrit ?</h3>
            <button onclick="window.location.href = '/inscription.php';" class="calltoaction2">Suivez-moi!<br>C'est par ici
                <img id="arrow" src="images/arrow-right-bold-box.svg">
            </button>
        </div>
    </div>
</section>

<?php include_once "includes/footer.php"; ?>