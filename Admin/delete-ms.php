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
use App\Models\MessagesModel;

require_once "../Autoloader.php";
Autoloader::register();

$messagesModel= new MessagesModel;
$id_ms= $_GET['id_ms'] ?? null;

if ($id_ms === null) {
    echo "Aucun messages n'a été trouvé";
    header('Location: messages.php');
    exit;
}
$message = $messagesModel->find($id_ms);
if (!$message) {
    echo  "L'identifiant n'a pas été récupéré";
    header('Location: messages.php');
    exit;
 }
 $messagesModel->delete($id_ms);
 $message= "Le message a été supprimé avec succès";

 $title = "Supprimer message ";

include_once "../includes/header.php";
?>

  <h3>Supprimer un messages</h3>
   
  <div class="delete"> 
    <p><?= $message ?></p>
  </div>


  <div class="selection">
    <div class="back">
      <a href= "messages.php" class="btn btn-warning">Gestion des commentaires</a>
      <a href="admin.php" class="btn btn-warning">Menu administration </a>
    </div>
  </div>
<?php include_once "../includes/footer.php";?>    