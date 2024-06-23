<?php

namespace App\Models;

use PDO;
use App\Db\Db;
use App\Autoloader;

require_once(__DIR__ . '/../Autoloader.php');

Autoloader::register();

/**
 * Modèle de la table "messages"
 */
class MessagesModel extends Model
{
    protected $id_ms;
    protected $pseudo;
    protected $created_at;
    protected $note;


    public function __construct()
    {
        $this->table = 'messages';
    }


    /**
     * Méthode d'affichage des messages
     *@param $Pseudo Pseudo de l'utilisateur
     *@param $created_at Date du message
     *@param $note Message de l'utilisateur
     * @return string
     */
    public function toHTML(): string
    {
        $pseudo = htmlspecialchars_decode($this->pseudo);
        $created_at = date('d/m/Y à H:i', strtotime($this->created_at));
        $note = nl2br(htmlspecialchars_decode($this->note));

        return <<<HTML
            <p>
                <strong>{$pseudo}</strong> <em>le {$created_at}</em><br>
                {$note}
            </p>
    HTML;
    }

    /**
     * Méthode permettant de récupérer les messages du livre d'or des utilisateurs
     *
     * @return $message
     */
    public function getAllMessages()
    {
        $db = Db::getInstance();

        $sql = "SELECT * FROM messages ORDER BY created_at DESC";
        $query = $db->query($sql);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($results as $result) {
            $message = new MessagesModel();
            $message->setIdMs($result['id_ms'])
                ->setPseudo($result['pseudo'])
                ->setCreatedAt($result['created_at'])
                ->setNote($result['note']);
            $messages[] = $message;
        }

        return $messages;
    }

     /**
     * Sélection d'un enregistrement en fonction de son id
     * @param integer $id_ms id de l'enregistrement
     * @return array Tableau contenant l'enregistrement trouvé
     */
    public function find(int $id_ms)
    {
        return $this->requete("SELECT * FROM $this->table WHERE `id_ms` = $id_ms")->fetch();
    }

      /**
     * Suppression d'un enregistrement par son id
     *
     * @param integer $id_ms
     * @return void
     */
    public function delete(int $id_ms)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE `id_ms`= ?", [$id_ms]);
    }

    /**
     * Get the value of id_ms
     */
    public function getIdMs()
    {
        return $this->id_ms;
    }

    /**
     * Set the value of id_ms
     */
    public function setIdMs($id_ms): self
    {
        $this->id_ms = $id_ms;

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
     * Get the value of note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set the value of note
     */
    public function setNote($note): self
    {
        $this->note = $note;

        return $this;
    }
}
