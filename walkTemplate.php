<?php

namespace App;

use App\Db\Db;

session_start();

 require_once "Autoloader.php";
 Autoloader::register();

$db = Db::getInstance();
$walkId = isset($_GET['id_w']) ? $_GET['id_w'] : null;
if ($walkId === null || !filter_var($walkId, FILTER_VALIDATE_INT)) {
    die("ID invalide");
}

$sql = "SELECT * FROM walks WHERE id_w = $walkId";
$query = $db->query($sql);
$walk = $query->fetch();

if (!$walk) {
  die("Randonnée non trouvée.");
}


$title = htmlspecialchars($walk->entitled);

include_once "includes/header.php";
?>

<main>
  <section class="walk">
    <?php
    $id_w = $walk->id_w;
    $comments = $db->query("SELECT * FROM `comments` WHERE `id_w` = $id_w")->fetchAll();

    $departmentMap = [
      1 => 'vaucluse.php',
      2 => 'gard.php',
      3 => 'drome.php',
      4 => 'bdr.php',
      5 => 'france.php'
    ];

    if (isset($departmentMap[$walk->department])) {
      $departmentFile = $departmentMap[$walk->department];
    } 
    ?>

    <div>
      <button class="go-back">
          <a href="<?= $departmentFile ?>?id_w=<?= $walk->id_w ?>">Retour</a>
      </button>
    </div>

    <div class="description">
      <h2><a id="<?= urlencode($walk->entitled) ?>"></a><?= $walk->entitled ?></h2>

      <h3>Intérêt de la randonnée</h3>

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
      <p><?= nl2br(htmlspecialchars_decode($walk->description)) ?></p>

      <h3>Tracé de la randonnée</h3>

      <div class="map" id="<?= $walk->id_w ?>"></div>

      <div class="feedback">

        <div class="comments">
          <a href="comments.php?id_w=<?= $walk->id_w ?>">Commentaires<img src="images/comment.png" alt="icone commentaire"></a>
        </div>

        <div class="download">
          <?php $gpx = $walk->geom; ?>
          <span>
            <a href="/mymaps/<?= $gpx ?>" download="<?= $gpx ?>">
              <button type="button">Télécharger GPX</button>
            </a>
          </span>
        </div>
      </div>
      <div class="display">
        <h4>Vos Commentaires</h4>
        <?php foreach ($comments as $comment) : ?>
          <p id="user"><?= htmlspecialchars($comment->pseudo) ?> le <?= date('d/m/Y à H:i', strtotime($comment->created_at)) ?></p>
          <p><?= nl2br(htmlspecialchars_decode($comment->comment)) ?></p>
        <?php endforeach; ?>
      </div>
      <?php
      if ($walk->images !== null) {
        $images = explode("\n", $walk->images);
      } else {
        $images = [];
      }
      ?>

      <h3>Galerie Photos</h3>
      <div class="gallery">
        <?php foreach ($images as $image) : ?>
          <img src="<?= $image ?>" alt="Photos">
        <?php endforeach; ?>
      </div>

    </div>
  </section>
</main>
<?php include_once "includes/footer.php"; ?>