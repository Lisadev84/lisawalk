<?php

namespace App\Models;

use App\Autoloader;
use App\Db\Db;

require_once(__DIR__ . '/../Autoloader.php');
Autoloader::register();


class Model extends Db
{
    // Table de la base de données
    protected $table;
    // Instance de connexion à la Db
    private $db;

    /**
     * Séléction de tous les enregistrements d'une table
     * @return array Tableau des enregistrements trouvés
     */
    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);

        return $query->fetchAll();
    }

    /**
     * Sélection de plusieurs enregistrements suivant un tableau de critères
     * @param array $criteres Tableau de critères
     * @return array Tableau des enregistrements trouvés
     */
    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];
        // on boucle pour éclater le tableau
        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?"; // pusher
            $valeurs[] = $valeur;
        }

        // on transforme le tableau "champs en une chaîne de caractères séparée par des AND
        $liste_champs = implode('AND', $champs);
        // on execute la requete
        return $this->requete("SELECT * FROM $this->table WHERE $liste_champs", $valeurs)->fetchAll();
    }

    /**
     * Récupérer un user à partir de son email
     * @param string $email
     * @return mixed
     */
    public function findOneByEmail(string $email)
    {
        $requete = "SELECT * FROM $this->table WHERE `email` = ?";
        $parameters = [$email];
        return $this->requete($requete, $parameters)->fetch();
    }

     /**
     * Récupérer un user à partir de son pseudo
     * @param string $pseudo Pseudo de l'utilisateur
     * @return mixed
     */
    public function findOneByPseudo(string $pseudo)
    {
        $requete = "SELECT * FROM $this->table WHERE `pseudo` = ?";
        $parameters = [$pseudo];
        return $this->requete($requete, $parameters)->fetch();
    }


    /**
     * Insertion d'un enregistrement suivant un tableau de données 
     * @return bool
     */
    public function create()
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        // on boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // EX : INSERT INTO users (name, firstname, pseudo, email, password) VALUES(?, ?, ?, ?, ?)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        // on transforme le tableau "champs" en une chaîne de caractères séparée par des ",'
        $liste_champs = implode(',', $champs);
        $liste_inter = implode(',', $inter);

        // on execute la requete
        return $this->requete('INSERT INTO ' . $this->table . ' (' . $liste_champs . ')VALUES(' . $liste_inter . ')', $valeurs) !== false;
    } 

    /**
     * Méthode qui exécutera les requêtes
     *
     * @param string $sql Requête SQL à exécuter
     * @param array|null $attributs Attributs à ajouter à la requête
     * @return PDOStatement |false
     */
    public function requete(string $sql, array $attributs = null)
    {
        // on récupère l'instance de Db
        $this->db = Db::getInstance();
        // on vérifie si on a des attributs
        if ($attributs !== null) {
            // requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // requête simple
            return $this->db->query($sql);
        }
    }


    /**
     * Hydratation des données
     *
     * @param array $donnees Tableau associatif des données
     * @return self Retourne l'objet hydraté
     */
    public function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {
            
            $method = 'set' . ucfirst($key);
            // on vérifie si le setter existe
            if (method_exists($this, $method)) {
                // on appelle le setter
                $this->$method($value);
            }
        }
        return $this;
    }
}
