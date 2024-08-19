<?php
namespace App\Admin;

use App\Autoloader;
use App\Models\WalksModel;

session_start();
   if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin'){
   }else{
      $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
       header('Location: index.php');
       exit;
   }    
require_once "../Autoloader.php";
Autoloader::register();

$walksModel = new WalksModel;
$walks = $walksModel->findAll();

$title = "Gestion randos";

include_once "../includes/header.php";
?>




<main>
    <h2>Liste des randonnées</h2>
  
    <section class="selection">
        <div class="add">
            <a href="ajoutrando.php" class="btn btn-warning">Ajouter</a>
            <a href="admin.php" class="btn btn-warning">Menu Admin</a>
            <a href="../index.php" class="btn btn-warning">Accueil</a> 
        </div>
    </section>

    <section class= "listing">
        <div class="table-responsive-xl">
            <table class="table-striped">
                <thead class="thead-light align-center">
                    <tr>
                        <th scope="col" style="width:3%;">Réf </th>
                        <th scope="col" style="width:10%;">Titre</th>
                        <th scope="col" style="width:25%;">Description</th>
                        <th scope="col" style="width:3%;">Durée</th>
                        <th scope="col">Départ</th>
                        <th scope="col">Arrivée</th>
                        <th scope="col">Distance</th>
                        <th scope="col">Dénivelé+</th>
                        <th scope="col">Dénivelé-</th>
                        <th scope="col">Niveau</th>
                        <th scope="col" style="width:5%;">Crée le</th>
                        <th scope="col">Déptm</th>
                        <th scope="col">GPX</th>
                        <th scope="col" style="width:10%;">Photos</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($walks as $walk) : ?>
                    <tr>
                        <td><?= $walk->id_w ?></td>
                        <td><?= htmlspecialchars($walk->entitled) ?></td>
                        <td><?= htmlspecialchars_decode($walk->description) ?></td>
                        <td><?= $walk->duration ?></td>
                        <td><?= htmlspecialchars($walk->start) ?></td>
                        <td><?= htmlspecialchars($walk->arrival) ?></td>
                        <td><?= $walk->distance ?>kms</td>
                        <td><?= $walk->dplus ?>m</td>
                        <td><?= $walk->dmoins ?>m</td>
                        <td><?= htmlspecialchars($walk->level) ?></td>
                        <td><?=date('d/m/Y à H:i', strtotime($walk->created_at)) ?></td>
                        <td><?= $walk->department ?></td>
                        <td><?= $walk->geom ?></td>
                        <td><?= $walk->images ?></td>
                        <td>
                            <a 
                                href="update-rando.php?id_w=<?= $walk->id_w ?>"><img src="../images/edit.svg" alt="stylo">
                            </a>
                            <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette randonnée ?')" 
                                href="delete-rando.php?id_w=<?=$walk->id_w ?>"><img src="../images/trash.svg" alt="corbeille"> 
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


