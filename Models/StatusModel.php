<?php

namespace App\Models;

use App\Autoloader;

require_once(__DIR__ . '/../Autoloader.php');

Autoloader::register();

/**
 * Modèle de la table "status"
 */
class StatusModel extends Model
{
  protected $status_id;
  protected $status;
  protected $user_id;
  protected $walk_id;

  public function __construct()
  {
    $this->table = 'status';
  }

  /**
   * Sélection d'un enregistrement en fonction de son id
   * @param integer $status_id, id de l'enregistrement
   * @return array Tableau contenant l'enregistrement trouvé
   */
  public function find(int $status_id)
  {
    return $this->requete("SELECT * FROM $this->table WHERE `status_id` = $status_id")->fetch();
  }

  /**
   * Suppression d'un enregistrement par son id
   *
   * @param integer $status_id
   * @return void
   */
  public function delete(int $status_id)
  {
    return $this->requete("DELETE FROM {$this->table} WHERE `status_id`= ?", [$status_id]);
  }

  /**
   * Get the value of status_id
   */
  public function getStatusId()
  {
    return $this->status_id;
  }

  /**
   * Set the value of id_com
   */
  public function setStatusId($status_id): self
  {
    $this->status_id = $status_id;

    return $this;
  }

  /**
   * Get the value of status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * Set the value of status
   */
  public function setStatus($status): self
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the value of user_id
   */
  public function getUserId()
  {
    return $this->user_id;
  }

  /**
   * Set the value of user_id
   */
  public function setUserId($user_id): self
  {
    $this->user_id = $user_id;

    return $this;
  }

  /**
   * Get the value of walk_id
   */
  public function getWalkId()
  {
    return $this->walk_id;
  }

  /**
   * Set the value of id_com
   */
  public function setWalkId($walk_id): self
  {
    $this->walk_id = $walk_id;

    return $this;
  }
}
