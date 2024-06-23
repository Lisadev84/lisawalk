<?php
namespace App\Models;

use App\Autoloader;

require_once(__DIR__ . '/../Autoloader.php');

Autoloader::register();

/**
 * Modele de la table "comments"
 */
class CommentsModel extends Model 
{
    protected $id_com;
    protected $pseudo;
    protected $created_at;
    protected $comment;
    protected $id;
    protected $id_w;

    public function __construct()
    {
        $this->table = "comments";
    }

    /**
     * Sélection d'un enregistrement en fonction de son id
     * @param integer $id_com,id de l'enregistrement
     * @return array Tableau contenant l'enregistrement trouvé
     */
    public function find(int $id_com)
    {
        return $this->requete("SELECT * FROM $this->table WHERE `id_com` = $id_com")->fetch();
    }

      /**
     * Suppression d'un enregistrement par son id
     *
     * @param integer $id_com
     * @return void
     */
    public function delete(int $id_com)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE `id_com`= ?", [$id_com]);
    }


    /**
     * Get the value of id_com
     */
    public function getIdCom()
    {
        return $this->id_com;
    }

    /**
     * Set the value of id_com
     */
    public function setIdCom($id_com): self
    {
        $this->id_com = $id_com;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     */
    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     */
    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id_u
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id_w
     */
    public function getIdW()
    {
        return $this->id_w;
    }

    /**
     * Set the value of id_w
     */
    public function setIdW($id_w): self
    {
        $this->id_w = $id_w;

        return $this;
    }

    /**
     * Get the value of pseudo
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     */
    public function setPseudo($pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
?>