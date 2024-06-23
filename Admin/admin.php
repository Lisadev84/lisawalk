<?php
namespace App\Admin;
session_start();

   // on vérifie si l'utilisateur est connecté et si role_admin est le rôle défini de la session
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
   
}else{
   // l'utilisateur n'est pas admin
   $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
    header('Location: ../index.php');
    exit;
}    

use App\Autoloader;

require_once "../Autoloader.php";
Autoloader::register();

$title = "Administration";

include_once "../includes/header.php";

?>

<main>
    <h2>Bienvenue dans la partie Administration</h2>

    <h3>Bonjour <?= $_SESSION["user"]["pseudo"] ?></h3>

    <section class ="admin">
        <div class="selection">
            <a href="randos.php" class="btn btn-warning">Gestion des randonnées</a>
            <a href="utilisateurs.php" class="btn btn-warning">Gestion des utilisateurs</a>
            <a href="commentaires.php" class="btn btn-warning">Gestion des commentaires</a>
            <a href="messages.php" class="btn btn-warning">Gestion des messages</a>
            <a href="../index.php" class="btn btn-warning">Retour à l'accueil</a>  
        </div>
    </section>
</main>

<?php include_once "../includes/footer.php"; ?>