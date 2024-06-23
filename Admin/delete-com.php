<?php
namespace App\Admin;

session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
}else{
  $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
  header('Location: index.php');
  exit;
}    
use App\Autoloader;
use App\Models\CommentsModel;

require_once "../Autoloader.php";
Autoloader::register();

$commentsModel= new CommentsModel;
$id_com = $_GET['id_com'] ?? null;

if ($id_com === null) {
    echo "Aucun commentaire n'a été trouvé";
    header('Location: commentaires.php');
    exit;
}
$comment = $commentsModel->find($id_com);
if (!$comment) {
    echo  "L'identifiant n'a pas été récupéré";
    header('Location: commentaires.php');
    exit;
 }
 $commentsModel->delete($id_com);
 $message= "Le commentaire a été supprimé avec succès";

 $title = "Supprimer commentaire ";

include_once "../includes/header.php";
?>

  <h3>Supprimer un commentaire</h3>
   
  <div class="delete"> 
    <p><?= $message ?></p>
  </div>


  <div class="selection">
    <div class="back">
      <a href= "commentaires.php" class="btn btn-warning">Gestion des commentaires</a>
      <a href="admin.php" class="btn btn-warning">Menu administration </a>
    </div>
  </div>
  


<?php include_once "../includes/footer.php";?>    