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
    ?>
    <div class="description">
      <h2><a id="<?= urlencode($walk->entitled) ?>"></a><?= $walk->entitled ?></h2>

      <h3>Intérêt de la randonnée</h3>
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