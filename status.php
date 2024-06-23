<?php

namespace App;

session_start();

use App\Autoloader;
use App\Db\Db;
use App\Models\StatusModel;

require_once "Autoloader.php";
Autoloader::register();

$db = Db::getInstance();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $walkId = filter_input(INPUT_POST, 'walk_id', FILTER_SANITIZE_NUMBER_INT);
  $statusKey = 'status_' . $walkId;
  $status = filter_input(INPUT_POST, $statusKey, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $userId = $_SESSION['user']['id'];

  if (empty($status)) {
    echo "veuillez choisir un statut pour votre randonnée.";
  } else {
    $statusModel = new StatusModel();
    $sql = "INSERT INTO status (user_id, walk_id, status) VALUES (:user_id, :walk_id, :status) ON DUPLICATE KEY UPDATE status = :status";
    $attributs = [
      ':user_id' => $userId,
      ':walk_id' => $walkId,
      ':status' => $status
    ];

    $result = $statusModel->requete($sql, $attributs);

    if ($result) {
      echo "La randonnée a été ajoutée dans votre page profil";
      header("Location:profil.php");
    } else {
      echo "Une erreur est survenue";
    }
  }
}
