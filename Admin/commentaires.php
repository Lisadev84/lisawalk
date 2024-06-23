<?php
namespace App\Admin;

use App\Autoloader;
use App\Models\CommentsModel;

// ini_set('display_errors', 1);
// error_reporting(E_ALL);
session_start();
   if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
   }else{
      $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
      header('Location: index.php');
      exit;
   }    

require_once "../Autoloader.php";
Autoloader::register();

$commentsModel= new CommentsModel;
$comments = $commentsModel->findAll();

$title = "Gestion des commentaires";


include_once "../includes/header.php";
?>

<main>
   <h2>Liste des commentaires</h2>

   <section class="selection">
        <div class="add">
            <a href="admin.php" class="btn btn-warning">Menu administration</a>
            <a href="../index.php" class="btn btn-warning">Accueil du site</a> 
        </div>
    </section>

    <section class= "listing">
        <div class="table-responsive">
            <table class="table-striped">
               <thead class="thead-light align-center">
                  <tr>
                     <th scope="col" style="width:5%;">Réf </th>
                     <th scope="col" style="width:15%;">Pseudo</th>
                     <th scope="col" style="width:15%;">créé le</th>
                     <th scope="col" style="width:40%;">commentaire</th>
                     <th scope="col">IdAuteur</th>
                     <th scope="col" >IdRando</th>
                     <th scope="col">Actions</th>
                  </tr>
               </thead>

               <tbody>
               <?php foreach ($comments as $comment) : ?>
                  <tr>
                     <td><?= $comment->id_com ?></td>
                     <td><?= htmlspecialchars($comment->pseudo) ?></td>
                     <td><?= $comment->created_at ?></td>
                     <td><?= htmlspecialchars($comment->comment) ?></td>
                     <td><?= $comment->id ?></td>
                     <td><?= $comment->id_w ?></td>
                     <td>
                        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer ce commentaire ?')" 
                        href="delete-com.php?id_com=<?=$comment->id_com ?>"><img src="../images/trash.svg" alt="corbeille"> 
                        </a>
                     </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section> 
</main>
<?php include_once "../includes/footer.php"; ?>