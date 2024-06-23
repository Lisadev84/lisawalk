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
use App\Models\WalksModel;

require_once "../Autoloader.php";
Autoloader::register();


$walksModel = new WalksModel();

$id_w = $_GET['id_w'] ?? null;

if ($id_w === null) {
   echo "Aucune randonnée n'a été trouvé";
    header('Location:randos.php');
    exit;
}

$walk = $walksModel->find($id_w);

if (!$walk) {
   echo  "L'identifiant n'a pas été récupéré";
    header('Location:randos.php');
    exit;
}

if (!empty ($walk)) {
    $geom = $walk->getGeom();
    $path1 = '../mymaps/'.$geom;

    if (file_exists($path1)) {
         unlink($path1);   
    }else{
        echo"Un erreur est survenue, le fichier n'a pas été supprimé";
    }

    $images= explode("\n",$walk->getImages());
    
        foreach ($images as $image) {
            $path2= '../photos/'.$image;
             if (file_exists($path2)) {
                 unlink($path2);   
            }else {
                 echo "Un erreur est survenue, le fichier n'a pas été supprimé";
            }
        }
        $walksModel->delete($id_w);
   
        $message= "La randonnée a été supprimée avec succès";    
}
    
$title = "Supprimer rando ";

include_once "../includes/header.php";
?>


    <h3>Supprimer une randonnée</h3>
   
    <div class="delete"> 
        <p><?= $message ?></p>
   </div>


    <div class="selection">
      <div class="back">
        <a href= "randos.php" class="btn btn-warning"> Gestion des randonnées</a>
        <a href="admin.php" class="btn btn-warning">Menu Administration</a>
      </div>
    </div>
  


<?php include_once "../includes/footer.php"; ?>    
