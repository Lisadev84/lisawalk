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
use App\Models\WalksModel;

require_once "../Autoloader.php";
Autoloader::register();

$walksModel = new WalksModel();

//on récupère la valeur du paramètre id_w depuis l'url et on l'assigne à $id_w
$id_w = $_GET['id_w'] ?? null;
if ($id_w === null) {
    echo "Aucune randonnée n'a été trouvé";
    header('Location:randos.php');
    exit;
}

$walk = $walksModel->find($id_w);
if (!$walk) {
    echo "L'identitfiant n'a pas été récupéré",
    header('Location:randos.php');
    exit;
}
$entitled = $walk->getEntitled();
$description = $walk->getDescription();
$duration = $walk->getDuration();
$start = $walk->getStart();
$arrival = $walk->getArrival();
$distance = $walk->getDistance();
$dplus = $walk->getDplus();
$dmoins = $walk->getDmoins();
$level = $walk->getLevel();
$created_at = $walk->getCreatedAt();
$geom = $walk->getGeom();
$department = $walk->getDepartment();
$images = explode("\n", $walk->getImages()); // Convertit la chaîne d'images en un tableau d'images


// vérifie que $images soit toujours un tableau même s'il n'y a pas d'images
 if (!is_array($images)) {
    $images = [];
}

if ((!empty($_POST))) {

    if (
        isset($_POST["entitled"], $_POST["description"], $_POST["duration"], $_POST["start"], $_POST["arrival"], $_POST["distance"], $_POST["dplus"], $_POST["dmoins"], $_POST["level"], $_POST["creation"], $_POST["department"]) && !empty($_POST["entitled"]) && !empty($_POST["description"]) && !empty($_POST["duration"]) && !empty($_POST["start"]) && !empty($_POST["arrival"]) && !empty($_POST["distance"]) && !empty($_POST["dplus"]) && !empty($_POST["dmoins"]) && !empty($_POST["level"]) && !empty($_POST["creation"]) && !empty($_POST["department"])

    ) {

        /**
         * Protection des données contre les injections XSS)
         */
        $entitled = ($_POST["entitled"]);
        $description = ($_POST["description"]);
        $duration = ($_POST["duration"]);
        $start = ($_POST["start"]);
        $arrival = ($_POST["arrival"]);
        $distance = ($_POST["distance"]);
        $dplus =($_POST["dplus"]);
        $dmoins = ($_POST["dmoins"]);
        $level = ($_POST["level"]);
        $created_at = (($_POST["creation"]));
        $department = ($_POST["department"]);


        if (isset($_FILES['gpx']) && ($_FILES['gpx']['error'] == 0)) {
            $dgpx = '../mymaps/';
            $tmp = $_FILES['gpx']['tmp_name'];
            if (!is_uploaded_file($tmp)) {
                exit("Le fichier est introuvable");
            }
            if ($_FILES['gpx']['size'] >= 1000000) {
                exit("Erreur, le fichier est trop volumineux");
            }
            $infofile = pathinfo($_FILES['gpx']['name']);
            $extension_upload = $infofile['extension'];
            $extension_upload = strtolower($extension_upload);
            $extension_allowed = array('gpx', 'xml');
            if (!in_array($extension_upload, $extension_allowed)) {
                exit("Erreur, veuillez insérer une image avec les extensions autorisées : gpx ou xml");
            }
            $geom = $_FILES['gpx']['name'];
            if (move_uploaded_file($tmp, $dgpx . $geom)) {
                echo 'Fichier envoyé avec succès';
            } else {
                exit("Impossible de copier le fichier");
            }
        }
      
        if (isset($_FILES['photo']) && is_array($_FILES['photo']['tmp_name'])) {

            foreach ($_FILES['photo']['tmp_name'] as $key => $tmp) {
                if (!empty($tmp)) {
                    $dphoto = '../photos/'. ($_FILES['photo']['name'][$key]);
                  
                    $movephoto = move_uploaded_file($tmp, $dphoto);
                    if ($movephoto) {
                        echo 'Image envoyée avec succès : '. $_FILES['photo']['name'][$key];
                        $images[] = ($dphoto);
                    } else {
                        echo 'Une erreur est survenue lors de l\'envoi de l\'image : '. $_FILES['photo']['name'][$key];
                    }
                }
            }
        }
    }

$walkUpdate = new WalksModel();
$walkUpdate->setIdW($id_w)
    ->setEntitled($entitled)
    ->setDescription($description)
    ->setDuration($duration)
    ->setStart($start)
    ->setArrival($arrival)
    ->setDistance($distance)
    ->setDplus($dplus)
    ->setDmoins($dmoins)
    ->setLevel($level)
    ->setCreatedAt($created_at)
    ->setGeom($geom)
    ->setDepartment($department)
    ->setImages(implode("\n", preg_replace('/^\n/', '',$images)));
    
$walkUpdate->update();
}
$title = "Modifier une rando";
include_once "../includes/header.php";
?>

<div class="container">
    <h3>Modifier une randonnée</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group col-4">
            <label for="entitled">Titre</label>
            <input type="text" name="entitled" id="entitled" value="<?= htmlspecialchars($entitled) ?>" class="form-control">
        </div>
        <div class="form-group col-4">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" onkeyup="textLimit(this, 2500);"><?= nl2br(htmlentities($description)) ?></textarea>
        </div>
        <div class="form-group col-2 ">
            <label for="duration">Durée</label>
            <input type="time" name="duration" id="duration" value="<?= ($duration) ?>" class="form-control">
        </div>
        <div class="form-group col-4">
            <label for="start">Lieu de départ</label>
            <input type="text" name="start" id="start" value="<?= htmlspecialchars($start) ?>" class="form-control">
        </div>
        <div class="form-group col-4">
            <label for="arrival">Lieu d'arrivée</label>
            <input type="text" name="arrival" id="arrival" value="<?= htmlspecialchars($arrival) ?>" class="form-control">
        </div>
        <div class="form-group col-4">
            <label for="distance">Distance</label>
            <input type="number" name="distance" id="distance" value="<?= ($distance) ?>" min="0" max="60" class="form-control">
        </div>
        <div class="form-group col-2">
            <label for="dplus">Dénivelé positif</label>
            <input type="number" name="dplus" id="dplus" value="<?= ($dplus) ?>" min="0" max="1400" class="form-control">
        </div>
        <div class="form-group col-2 ">
            <label for="dmoins">Dénivelé négatif</label>
            <input type="number" name="dmoins" id="dmoins" value="<?= ($dmoins) ?>" min="0" max="1200" class="form-control">
        </div>
        <div class="form-group col-4">
            <label for="level">Difficulté</label>
            <input type="text" name="level" id="level" value="<?= htmlspecialchars($level) ?>" class="form-control">
        </div>
        <div class="form-group col-2 ">
            <label for="creation">créée le</label>
            <input type="date" name="creation" id="creation" value="<?= ($created_at) ?>" class="form-control">
        </div>
        <div class="form-group col-4">
            <label for="department">Département</label>
            <input type="number" name="department" id="department" value="<?= ($department) ?>" min="1" max="5" class="form-control">
        </div>

        <div class="form-group col-4">
            <label for="gpx">Trace GPX</label>
            <input type="file" name="gpx" id="gpx" class="form-control">
            <?php if ($geom) : ?>
                <input type="text" value="<?= $geom ?>" readonly class="form-control">
            <?php endif; ?>
        </div>

        <div class="form-group col-4">
            <p>Sélectionner les images</p>
            <input type="file" name="photo[]" id="photo" multiple class="form-control">
             <?php if (isset($images)) : ?> 
                <?php foreach ($images as $image) : ?>
                    <input type="text" value="<?= preg_replace('/^\n/', '', $image)?>" readonly class="form-control">
                <?php endforeach; ?>
             <?php endif; ?> 
        </div>

        <div class="submit">
            <button class="btn mt-4 mb-4" type="submit">Modifier</button>
            <a href="../index.php" class="btn btn-warning">Retour à l'accueil</a>
            <a href= "randos.php" class="btn btn-warning">Retour Gestion des randonnées</a>
        </div>
    </form>
</div>


<?php include_once "../includes/footer.php"; ?>