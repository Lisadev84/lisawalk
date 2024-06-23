<?php
namespace App\Models;

use App\Autoloader;

require_once(__DIR__ . '/../Autoloader.php');

Autoloader::register();


/**
 * Modèle de la table "users"
 */
class UsersModel extends Model
{
    protected $id;
    protected $username;
    protected $firstname;
    protected $pseudo;
    protected $email;
    protected $password;
    protected $role;
    protected $consentement_cgu;

    public function __construct()
    {
        $this->table = 'users';
    }

    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'pseudo' => $this->pseudo,
            'email' => $this->email,
            'role' =>$this->role
        ];
    }  
    

    /**
     * Sélection d'un enregistrement en fonction de son id
     * @param integer $id id de l'enregistrement
     * @return array Tableau contenant l'enregistrement trouvé
     */
    public function find(int $id)
    {
        return $this->requete("SELECT * FROM $this->table WHERE `id` = $id")->fetch();
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
        $valeurs[] = $this->id;

        // on transforme le tableau "champs" en une chaîne de caractères séparée par des ",'
        $liste_champs = implode(',', $champs);

        // on execute la requete
        return $this->requete('UPDATE '.$this->table. ' SET '. $liste_champs. ' WHERE id = ?', $valeurs);
    }

     /**
     * Suppression d'un enregistrement par son id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE `id`= ?", [$id]);
    }


  

     /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }



    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     */
    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;

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
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }

    

    /**
     * Get the value of consentement_cgu
     */
    public function getConsentementCgu()
    {
        return $this->consentement_cgu;
    }

    /**
     * Set the value of consentement_cgu
     */
    public function setConsentementCgu($consentement_cgu): self
    {
        $this->consentement_cgu = $consentement_cgu;

        return $this;
    }
}