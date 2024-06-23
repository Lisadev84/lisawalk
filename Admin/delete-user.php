<?php
namespace App\Admin;

session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
}else{
  // l'utilisateur n'est pas admin
  $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
  header('Location: index.php');
  exit;
}    
use App\Autoloader;
use App\Models\UsersModel;

require_once "../Autoloader.php";
Autoloader::register();

$usersModel = new UsersModel;
$id = $_GET['id'] ?? null;

if ($id === null) {
   echo "Aucun utilisateur n'a été trouvé";
    header('Location: utilisateurs.php');
    exit;
}
$user = $usersModel->find($id);
if (!$user) {
  echo  "L'identifiant n'a pas été récupéré";
  header('Location: utilisateurs.php');
  exit;
}
 $usersModel->delete($id);
 $message= "L'utilisateur a été supprimé avec succès";

 $title = "Supprimer utilisateur ";

include_once "../includes/header.php";
?>


<h3>Supprimer un utilisateur</h3>
   
  <div class="delete"> 
    <p><?= $message ?></p>
  </div>

  <div class="selection">
    <div class="back">
      <a href= "utilisateurs.php" class="btn btn-warning">Gestion des utilisateurs</a>
      <a href="admin.php" class="btn btn-warning">Menu administration </a>
      </div>
  </div>
  


<?php include_once "../includes/footer.php"; ?>    

 