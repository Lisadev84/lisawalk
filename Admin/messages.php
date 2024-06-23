<?php
namespace App\Admin;

use App\Autoloader;
use App\Models\MessagesModel;

session_start();
   if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
   }else{
      $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
      header('Location: index.php');
      exit;
   }    

require_once "../Autoloader.php";
Autoloader::register();

$messagesModel= new MessagesModel;
$messages = $messagesModel->findAll();

$title = "Gestion des messages";


include_once "../includes/header.php";
?>

<main>
   <h2>Liste des messages</h2>

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
                     <th scope="col">Pseudo</th>
                     <th scope="col"style="width:15%;">créé le</th>
                     <th scope="col" style="width:55%;">Message</th>
                     <th scope="col">Actions</th>
                  </tr>
               </thead>

               <tbody>
               <?php foreach ($messages as $message) : ?>
                  <tr>
                     <td><?= $message->id_ms ?></td>
                     <td><?= htmlspecialchars($message->pseudo) ?></td>
                     <td><?=date('d/m/Y à H:i', strtotime($message->created_at)) ?></td>
                     <td><?= htmlspecialchars($message->note) ?></td>
                     <td>
                        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer ce message ?')" 
                        href="delete-ms.php?id_ms=<?=$message->id_ms ?>"><img src="../images/trash.svg" alt="corbeille"> 
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