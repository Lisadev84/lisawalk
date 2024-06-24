<?php
namespace App;

session_start();
if (isset($_SESSION["user"])) {
    header("Location: profil.php");
    exit;
}

use App\Autoloader;
use App\Models\UsersModel;
use App\Db\Db;

require_once "Autoloader.php";
Autoloader::register();

$error="";

if ((!empty($_POST))) {
    if (
        isset($_POST["username"], $_POST["firstname"], $_POST["pseudo"], $_POST["email"], $_POST["pass"], $_POST["consent"])
        && !empty($_POST["username"]) && !empty($_POST["firstname"]) && !empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST["pass"])
    ) {
        /**
         * Protection des données des éventuelles injections XSS
         */
        $username = htmlspecialchars($_POST["username"]);
        $firstname = htmlspecialchars($_POST["firstname"]);
        $pseudo = htmlspecialchars($_POST["pseudo"]);
        $email = htmlspecialchars($_POST["email"]);

         /**
         * Vérification de la structure de l'email
         */
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("l'adresse email est incorrecte");
        }
        /**
        * verification de l'unicité du pseudo et de l'email
        */
         $db = Db::getInstance();
         $sql = "SELECT * FROM `users` WHERE `pseudo` = :pseudo";
         $query = $db->prepare($sql);
         $query->execute([':pseudo' => $pseudo]);
         $result = $query->fetchAll();

        if (!empty($result)) {
           $error=("Ce pseudo est déjà utilisé");
        }
        
        $sql = "SELECT * FROM `users` WHERE `email` = :email";
        $query = $db->prepare($sql);
        $query->execute([':email' => $email]);
        $result = $query->fetchAll();

        if(!empty($result)) {
           $error=("Cet email est déjà utilisé");
        }
        
        /**
         * hachage du mot de passe
         */
        $password = password_hash($_POST["pass"], PASSWORD_ARGON2ID);

         /**
         * Vérification du consentement des CGU
         */
        $consentement_cgu = isset($_POST["consent"]) ? 1 : 0;


        if(empty($error)) {
            $user = new UsersModel;
            $donnees = ($_POST);
            $user->setUsername($username)
                ->setFirstname($firstname)
                ->setPseudo($pseudo)
                ->setEmail($email)
                ->setPassword($password)
                ->setConsentementCgu($consentement_cgu);
    
            $user->create();
        
        /**
         * récupération de l'Id du nouvel utilisateur
         */
        $id=$db->lastInsertId();

        $_SESSION["user"] =
            [
                "id" => $id,
                "pseudo" => $pseudo,
                "email" => $_POST["email"],
               "role" => ["role_user"]
            ];
        header("Location: profil.php");
        }
    } else {
        die("le formulaire est incomplet");
    }    
}
$title = "inscription";
include_once "includes/header.php";
?>
<section class="inscription">

    <h3>Renseignez ce formulaire d'inscription puis découvrez les randonnées à votre disposition</h3>

    <form action="" method="post">
        <div class="form-group">
            <label for="username">Nom</label>
            <input type="text" name="username" id="username" class="form-control" autocomplete = "name" required>
        </div>
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" class="form-control" required>
            <?php if (!empty($error) && strpos($error, 'pseudo') !== false): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" autocomplete ="email" required>
            <?php if (!empty($error) && strpos($error, 'email') !== false): ?>
                <div class="error-message">
                 <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="pass">Mot de passe</label>
            <input type="password" name="pass" id="pass" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="consent"></label>
            <div>
                <input type="checkbox" name="consent" id="consent" required>
                <label for="consent">J'accepte les <a href="ml.php" target="_blank">conditions générales d'utilisation et politique de confidentialité</a></label>
            </div>
        </div>

        <div class="submit">
            <button class="btn mt-2 mb-4" type="submit">Soumettre</button>
        </div>
    </form>
</section>

<?php
include_once "includes/footer.php";
?>