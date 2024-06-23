<?php
namespace App;

use App\Models\CommentsModel;
use App\Db\Db;
use App\Autoloader;
use App\Models\WalksModel;

session_start();

require_once "Autoloader.php";
Autoloader::register();


if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"]["id"];

} else {
    $_SESSION['erreur'] = ("Vous devez être connecté avant d'envoyer un commentaire");
    header('Location: auth.php');
    exit;
}
if (isset($_GET["id_w"])) {
    $id_w = $_GET["id_w"];
} else {
    echo("Une erreur est survenue");
    header("Location: index.php");
}


if ( isset($_POST["pseudo"],$_POST["comment"]) && !empty($_POST["pseudo"]) && !empty($_POST["comment"])){
    /**
    * Protection des données des injections XSS
    */
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $comment = htmlspecialchars_decode($_POST["comment"]);
    $created_at = date("Y-m-d H:i:s");

    $commentary = new CommentsModel;
    $donnees = ($_POST);

    $commentary->setPseudo($pseudo)
    ->setComment($comment)
    ->setCreatedAt($created_at)
    ->setId($id)
    ->setIdW($id_w);
    $commentary->create();
    
    $walksModel = new WalksModel();
    $id_w = $_GET['id_w'];
    $walk = $walksModel->find($id_w);

    // Récupére le numéro du département associé à la randonnée
    $department= $walk->getDepartment(); 

   
    // Rediriger l'utilisateur en fonction du numéro du département
    switch ($department)  {
        case 1:
        header("Location: vaucluse.php");
        break;
        case 2: 
        header("Location: gard.php");
        break;
        case 3:    
        header("Location: drome.php");
        break;
        case 4:
        header("Location: bdr.php");
        break;
        case 5:
        header("Location: france.php");
        break;
    }  
} 
$title = "commentaire";
include_once "includes/header.php";
?>
<section class="com">
    <h3>Commentaires</h3>


    <form action="" method="post">
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" class="form-control" required>
        </div>
       
        <div class="form-group">
            <label for="comment">Votre commentaire</label>
           <textarea rows="15" cols="40" class="form-control" id="comment" name="comment" onkeyup="textLimit(this, 500);"required placeholder="Ecrivez votre commentaire ici max.500 caractères"></textarea>
        </div>
        <div class="submit">
            <button class="or" class="btn mt-3 mb-4" type="submit"> Envoyer</button>
        </div>
    </form>
</section>
<?php
include_once "includes/footer.php";?>