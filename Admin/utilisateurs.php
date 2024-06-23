<?php
namespace App\Admin;

use App\Autoloader;
use App\Models\UsersModel;

session_start();
   if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
   }else{
      $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
      header('Location: index.php');
      exit;
   }    

require_once "../Autoloader.php";
Autoloader::register();

$usersModel= new UsersModel;
$users = $usersModel->findAll();

$title = "Gestion des utilisateurs";


include_once "../includes/header.php";
?>

<main>
   <h2>Liste des utilisateurs</h2>

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
                     <th scope="col" style="width:3%;">Réf </th>
                     <th scope="col" style="width:10%;">Nom</th>
                     <th scope="col" style="width:10%;">Prénom</th>
                     <th scope="col">Pseudo</th>
                     <th scope="col"style="width:15%;">Email</th>
                     <th scope="col" style="width:25%;">Mot de passe</th>
                     <th scope="col">Rôle</th>
                     <th scope="col">Actions</th>
                  </tr>
               </thead>

               <tbody>
               <?php foreach ($users as $user) : ?>
                  <tr>
                     <td><?= $user->id ?></td>
                     <td><?= htmlspecialchars($user->username) ?></td>
                     <td><?= htmlspecialchars($user->firstname) ?></td>
                     <td><?= htmlspecialchars($user->pseudo) ?></td>
                     <td><?= htmlspecialchars($user->email) ?></td>
                     <td><?= $user->password ?></td>
                     <td><?= htmlspecialchars($user->role)?></td>
                     <td>
                        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cet utilisateur ?')" 
                        href="delete-user.php?id=<?=$user->id ?>"><img src="../images/trash.svg" alt="corbeille"> 
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