<?php

namespace App\Admin;

session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'role_admin') {
} else {
    $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
    header('Location: ../index.php');
    exit;
}

use App\Autoloader;
use App\Models\WalksModel;
use App\Db\Db;

require_once "../Autoloader.php";
Autoloader::register();


if ((!empty($_POST))) {

    if (
        isset($_POST["entitled"], $_POST["description"], $_POST["duration"], $_POST["start"], $_POST["arrival"], $_POST["distance"], $_POST["dplus"], $_POST["dmoins"], $_POST["level"], $_POST["creation"], $_POST["department"]) && !empty($_POST["entitled"]) && !empty($_POST["description"]) && !empty($_POST["duration"]) && !empty($_POST["start"]) && !empty($_POST["arrival"]) && !empty($_POST["distance"]) && !empty($_POST["dplus"]) && !empty($_POST["dmoins"]) && !empty($_POST["level"]) && !empty($_POST["creation"]) && !empty($_POST["department"])

    ) {

        /**
         * Protection des données contre les injections XSS)
         */
        $entitled = html_entity_decode($_POST["entitled"]);
        $description = nl2br(html_entity_decode($_POST["description"]));
        $duration = htmlspecialchars($_POST["duration"]);
        $start = html_entity_decode($_POST["start"]);
        $arrival = html_entity_decode($_POST["arrival"]);
        $distance = htmlspecialchars($_POST["distance"]);
        $dplus = htmlspecialchars($_POST["dplus"]);
        $dmoins = htmlspecialchars($_POST["dmoins"]);
        $level = htmlspecialchars($_POST["level"]);
        $created_at = htmlspecialchars(($_POST["creation"]));
        $department = htmlspecialchars($_POST["department"]);


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
        $images = array(); // Tableau pour stocker les noms des images
        if (isset($_FILES['photo']) && is_array($_FILES['photo']['tmp_name'])) {

            foreach ($_FILES['photo']['tmp_name'] as $key => $tmp) {
                if (!empty($tmp)) {
                    $dphoto = '../photos/' . (($_FILES['photo']['name'][$key]));

                    $movephoto = move_uploaded_file($tmp, $dphoto);
                    if ($movephoto) {
                        echo 'Images envoyées avec succès : ' . $_FILES['photo']['name'][$key];
                        $images[] = ($dphoto);
                    } else {
                        echo 'Une erreur est survenue lors de l\'envoi des images : ' . $_FILES['photo']['name'][$key];
                    }
                }
            }
        }
    }

    $walk = new WalksModel;

    $donnees = $_POST;
    $walk->setEntitled($entitled)
        ->setDescription(htmlentities($description))
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
        ->setImages(implode("\n", $images));

    $walk->create();

    $db = Db::getInstance();
    $newHikeId = $db->lastInsertId();

    $newGpxFileName = $newHikeId . '.gpx';
    $newGpxFilePath = $dgpx . $newGpxFileName;
    if (rename($dgpx . $geom, $newGpxFilePath)) {
        // Mettre à jour la variable $geom avec le nouveau nom de fichier
        $geom = $newGpxFileName;
        var_dump($geom);
        // Mettre à jour l'entrée dans la base de données avec le nouveau nom de fichier GPX
        $walk->setGeom($geom)->update();
        var_dump($walk);
    } else {
        exit("Impossible de renommer le fichier");
    }

    header('Location:randos.php');
}


$title = "Ajout rando";

include_once "../includes/header.php";
?>
<section class="selection">
    <div class="add">
        <a href="admin.php" class="btn btn-warning">Menu administration</a>
        <a href="../index.php" class="btn btn-warning">Accueil du site</a>
    </div>

    <div class="container">
        <h3>Ajouter une randonnée</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group col-4">
                <label for="entitled">Titre</label>
                <input type="text" name="entitled" id="entitled" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" onkeyup="textLimit(this, 2500);"></textarea>
            </div>
            <div class="form-group col-2 ">
                <label for="duration">Durée</label>
                <input type="time" name="duration" id="duration" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="start">Lieu de départ</label>
                <input type="text" name="start" id="start" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="arrival">Lieu d'arrivée</label>
                <input type="text" name="arrival" id="arrival" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="distance">Distance</label>
                <input type="number" name="distance" id="distance" min="0" max="60" class="form-control">
            </div>
            <div class="form-group col-2">
                <label for="dplus">Dénivelé positif</label>
                <input type="number" name="dplus" id="dplus" min="0" max="1400" class="form-control">
            </div>
            <div class="form-group col-2 ">
                <label for="dmoins">Dénivelé négatif</label>
                <input type="number" name="dmoins" id="dmoins" min="0" max="1400" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="level">Difficulté</label>
                <input type="text" name="level" id="level" class="form-control">
            </div>
            <div class="form-group col-2 ">
                <label for="creation">créée le</label>
                <input type="date" name="creation" id="creation" class="form-control">
            </div>
            <div class="form-group col-4">
                <label for="department">Département</label>
                <input type="number" name="department" id="department" min="1" max="5" class="form-control">
            </div>

            <div class="form-group col-4">
                <label for="gpx">Trace GPX</label>
                <input type="file" name="gpx" id="gpx" class="form-control">
            </div>

            <div class="form-group col-4">
                <p>Sélectionner les images</p>
                <input type="file" name="photo[]" id="photo" multiple class="form-control">
            </div>

            <div class="submit">
                <button class="btn mt-4 mb-4" type="submit">Enregistrer</button>
            </div>
        </form>
    </div>
</section>


<?php include_once "../includes/footer.php"; ?>