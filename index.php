<?php
namespace App;

use App\Db\Db;

session_start();
require_once "Autoloader.php";
Autoloader::register();


$db = Db::getInstance();
$sql = "SELECT * FROM `walks`ORDER BY `created_at` DESC LIMIT 8";
$query = $db->query($sql);
$walks = $query->fetchAll();

include_once "includes/header.php";
?>

<section>
    <article>

        <h1> Bienvenue sur le site LisaWalk</h1>
        <div>
            <p>Passionnée de randonnées pédestres depuis de nombreuses années, j'ai pu découvrir la richesse patrimoniale, le charme de différentes régions et le plaisir d'être au contact de la nature. Je souhaite partager avec vous ces découvertes, ces agréables moments passés et les itinéraires empruntés. <br>
            Vous trouverez sur le site, des randonnées classées par département, accompagnées d'une fiche technique, de sa trace gpx téléchargeable et d'une galerie photos. <br>
            Je vous souhaite de belles balades.</p>
        </div>
        <div class="action">
            <img src="images/photoaccueil.png" alt="randonneuse et borie">
            <button onclick="window.location.href = 'inscription.php';" class="calltoaction">Pour vous inscrire,<br> suivez-moi!<br> C'est par ici<img id="arrow" src="images/arrow-right-bold-box.svg"></button>
        </div>
    </article>

    <aside>
        <h2>Randonnées récentes</h2>
        <?php foreach ($walks as $walk) : ?>
            <p><?= $created_at = date('d/m/Y', strtotime($walk->created_at)); ?></p>
            <?php
            $department = $walk->department;
            $file = '';

            if ($department == 1) {
                $file = 'vaucluse.php';
            } elseif ($department == 2) {
                $file = 'gard.php';
            } elseif ($department == 3) {
                $file = 'drome.php';
            } elseif ($department == 4) {
                $file = 'bdr.php';
            } elseif ($department == 5) {
                $file = 'france.php';
            }
            ?>
            <?php if (isset($_SESSION["user"])) : ?>
                <a href="<?= $file ?>?id=<?= $walk->id_w ?>#<?= urlencode($walk->entitled) ?>"><?= $walk->entitled ?></a>
            <?php else : ?>
                <span class="aside"><?= $walk->entitled ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </aside>
</section>


<?php
include_once "includes/footer.php";
?>