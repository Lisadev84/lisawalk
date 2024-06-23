<?php
namespace App\Models;

use App\Autoloader;

require_once(__DIR__ . '/../Autoloader.php');

Autoloader::register();

/**
 * Modèle de la table "walks"
 */
class WalksModel extends Model
{
    protected $id_w;
    protected $entitled;
    protected $description;
    protected $duration;
    protected $start;
    protected $arrival;
    protected $distance;
    protected $dplus;
    protected $dmoins;
    protected $level;
    protected $created_at;
    protected $geom; 
    protected $department;
    protected $images;

    public function __construct()
    {
        $this->table = 'walks';
    }       


    /**
     * Sélection d'un enregistrement en fonction de son id
     * @param integer $id_w id de l'enregistrement
     * @return array Tableau contenant l'enregistrement trouvé
     */
    public function find(int $id_w)
    {
        return $this->requete("SELECT * FROM $this->table WHERE `id_w` = $id_w")->fetchObject(static::class);
    } 

    
     /**
     * Mise à jour d'un enregistrement suivant un tableau de données
     * @return bool
     */
    public function update()
    {
        $champs = [];
        $valeurs = [];

        // on boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // EX : UPDATE users SET name = ?, firstname = ?, pseudo = ?, email = ?, password = ?) WHERE id =?
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $this->id_w;

        // on transforme le tableau "champs" en une chaîne de caractères séparée par des ",'
        $liste_champs = implode(',', $champs);

        // on execute la requete
        return $this->requete('UPDATE '.$this->table. ' SET '. $liste_champs. ' WHERE id_w = ?', $valeurs);
    }

      /**
     * Suppression d'un enregistrement par son id
     *
     * @param integer $id_w
     * @return void
     */
    public function delete(int $id_w)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE `id_w`= ?", [$id_w]);
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
     * Get the value of entitled
     */
    public function getEntitled()
    {
        return $this->entitled;
    }

    /**
     * Set the value of entitled
     */
    public function setEntitled($entitled): self
    {
        $this->entitled = $entitled;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     */
    public function setDuration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the value of start
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set the value of start
     */
    public function setStart($start): self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get the value of arrival
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set the value of arrival
     */
    public function setArrival($arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get the value of distance
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set the value of distance
     */
    public function setDistance($distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get the value of dplus
     */
    public function getDplus()
    {
        return $this->dplus;
    }

    /**
     * Set the value of dplus
     */
    public function setDplus($dplus): self
    {
        $this->dplus = $dplus;

        return $this;
    }

    /**
     * Get the value of dmoins
     */
    public function getDmoins()
    {
        return $this->dmoins;
    }

    /**
     * Set the value of dmoins
     */
    public function setDmoins($dmoins): self
    {
        $this->dmoins = $dmoins;

        return $this;
    }

    /**
     * Get the value of level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set the value of level
     */
    public function setLevel($level): self
    {
        $this->level = $level;

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
     * Get the value of geom
     */
    public function getGeom()
    {
        return $this->geom;
    }

    /**
     * Set the value of geom
     */
    public function setGeom($geom): self
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get the value of department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set the value of department
     */
    public function setDepartment($department): self
    {
        $this->department = $department;

        return $this;
    }


    /**
     * Get the value of images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set the value of images
     */
    public function setImages($images): self
    {
        $this->images = $images;

        return $this;
    }
}

?>