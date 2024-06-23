<?php

namespace App;

use App\Db\Db;

session_start();

require_once "Autoloader.php";
Autoloader::register();

$db = Db::getInstance();

$sql = "SELECT * FROM `walks` WHERE `department` = 2 ORDER BY `created_at` DESC";
$query = $db->query($sql);
$walks = $query->fetchAll();

$title = "Gard";
include_once "includes/header.php";

?>

<main class="department">
    <h1>Randonnées dans Le Gard</h1>
    <div class="row row-cols-1 row-cols-sm-4 g-4">
        <?php foreach ($walks as $walk) : ?>
            <?php
            $images = explode("\n", $walk->images);
            $firstImage = trim($images[0]);
            ?>
            <div class="col">
                <div class="card">
                    <img src="<?= !empty($firstImage) ? $firstImage : '/images/defaultPhoto.png' ?>" class="card-img-top" alt="photo de la randonnée">
                    <div class="card-body">
                        <h5 class="card-title"><?= $walk->entitled ?></h5>
                        <div class="table-responsive-xl">
                            <table class=" table table-bordered border-black table ">
                                <thead class="thead-light align-center">
                                    <tr>
                                        <th scope="col"><img src="images/distance-outline.svg" alt="icone distance"></th>
                                        <th scope="col"><img src="images/altitude-outline-rounded.svg" alt="icone denivelé positif"></th>
                                        <th scope="col"><img src="images/slope-downhill.svg" alt="icone dénivelé négatif"></th>
                                        <th scope="col"><img src="images/clock-hour-8.svg" alt="icone durée"></th>
                                        <th scope="col"><img src="images/skill-level.svg" alt="icone level"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?= $walk->distance ?>kms</td>
                                        <td><?= $walk->dplus ?>m</td>
                                        <td><?= $walk->dmoins ?>m</td>
                                        <td><?= $walk->duration ?></td>
                                        <td><?= htmlspecialchars($walk->level) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive-xl"> 
                            <table class=" table table-bordered border-black table ">
                                <thead class="thead-light align-center">
                                    <tr>
                                        <th scope="col"><img src="images/icostart.png" alt="icone depart"></th>
                                        <th scope="col"><img src="images/icoend.png" alt="icone arrivée"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td><?= htmlspecialchars($walk->start) ?></td>
                                        <td><?= htmlspecialchars($walk->arrival) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="status">
                            <a href="walkTemplate.php?id_w=<?= $walk->id_w ?>">Voir les détails</a>
                            
                            <form action="status.php" method="post">
                                <div>
                                    <input type="radio" id="realized_<?= $walk->id_w ?>" name="status_<?= $walk->id_w ?>" value="realized" />
                                    <label for="realized_<?= $walk->id_w ?>">Réalisée</label>
                                </div>
                                <div>
                                    <input type="radio" id="must-do_<?= $walk->id_w ?>" name="status_<?= $walk->id_w ?>" value="must-do" />
                                    <label for="must-do_<?= $walk->id_w ?>">A faire</label>
                                </div>
                                <input type="hidden" name="walk_id" value="<?= $walk->id_w ?>" />
                                <input type="submit" value="Enregistrer" id="button" />
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php unset($walks); ?>
    </div>
</main>
<?php include_once "includes/footer.php"; ?>