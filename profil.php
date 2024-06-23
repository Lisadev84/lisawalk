<?php

namespace App;

use App\Db\Db;

session_start();

require_once "Autoloader.php";
Autoloader::register();

$db = Db::getInstance();

$userId = $_SESSION['user']['id'];


$sql = "SELECT walks.*, status.status FROM walks 
        JOIN status ON walks.id_w = status.walk_id
        WHERE status.user_id = :userId AND status.status = 'must-do'";
$query = $db->prepare($sql);
$query->execute(['userId' => $userId]);
$mustDoWalks = $query->fetchAll();

$sql = "SELECT walks.*, status.status FROM walks 
        JOIN status ON walks.id_w = status.walk_id
        WHERE status.user_id = :userId AND status.status = 'realized'";
$query = $db->prepare($sql);
$query->execute(['userId' => $userId]);
$realizedWalks = $query->fetchAll();



$titre = "Profil";
include "includes/header.php";

?>
<main class="profil">
    <h3>Bienvenue sur votre profil</h3>

    <h4>Mes informations</h4>
    <div class="info-container">
        <p><strong>Pseudo</strong> : <?= $_SESSION["user"]["pseudo"] ?></p>
        <p><strong>Email :</strong> <?= $_SESSION["user"]["email"] ?></p>
    </div>

    <h4>Mes randonnées à faire</h4>
    <div class="mustDo-list">
        <ul>
            <?php foreach ($mustDoWalks as $walk) : ?>
                <li>
                    <a href="walkTemplate.php?id_w=<?= $walk->id_w ?>"><?= htmlspecialchars($walk->entitled) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <h4>Mes randonnées réalisées</h4>
    <div class="realized-list">
        <ul>
            <?php foreach ($realizedWalks as $walk) : ?>
                <li>
                    <a href="walkTemplate.php?id_w=<?= $walk->id_w ?>"><?= htmlspecialchars($walk->entitled) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>

<?php include "includes/footer.php"; ?>