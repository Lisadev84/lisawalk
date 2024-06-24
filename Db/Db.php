<?php
 namespace App\Db;

require dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Dotenv\Exception\ValidationException;

// On importe PDO
use PDO;
use PDOException;

class Db extends PDO                                   
{
    // Instance unique et privée de la classe
    private static $instance;

    // Variables de connexion à la base de données
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;

    private function __construct()
    {
        // Charger les variables d'environnement en utilisant safeLoad
        $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/.env', 'Db.env');
        
        try {
            $dotenv->safeLoad();
            $dotenv->required(['DBHOST', 'DBUSER', 'DBPASS', 'DBNAME'])->notEmpty();
        } catch (InvalidPathException $e) {
            die("Erreur: Impossible de charger le fichier .env: " . $e->getMessage());
        } catch (ValidationException $e) {
            die("Erreur: Les variables d'environnement requises ne sont pas définies: " . $e->getMessage());
        }

        $this->dbhost = $_SERVER['DBHOST'] ?? null;
        $this->dbuser = $_SERVER['DBUSER'] ?? null;
        $this->dbpass = $_SERVER['DBPASS'] ?? null;
        $this->dbname = $_SERVER['DBNAME'] ?? null;

        if (!$this->dbhost || !$this->dbuser || !$this->dbpass || !$this->dbname) {
            die("Erreur: Les variables d'environnement pour la connexion à la base de données ne sont pas correctement définies.");
        }

        // DSN de connexion 
        $_dsn = 'mysql:dbname=' . $this->dbname . ';host=' . $this->dbhost;

        // On appelle le constructeur de la classe PDO
        try {
            parent::__construct($_dsn, $this->dbuser, $this->dbpass);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    // Méthode qui permet de récupérer l'instance unique de la classe
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

// <!-- </?php

// namespace App\Db;

// require dirname(__DIR__) . '/vendor/autoload.php';

// use Dotenv\Dotenv;

// // On importe PDO
// use PDO;
// use PDOException;

// class Db extends PDO                                   
// {
//     // Instance unique et privée de la classe
//     private static $instance;

   
//     private $dbhost;
//     private $dbuser;
//     private $dbpass;
//     private $dbname;

//     private function __construct()
//     {
//         // Charger les variables d'environnement
//         $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/.env', 'Db.env');
//         $dotenv->load();

//         // Assigne les valeurs des variables d'environnement aux propriétés de la classe
//         $this->dbhost = $_ENV['DBHOST'];
//         $this->dbuser = $_ENV['DBUSER'];
//         $this->dbpass = $_ENV['DBPASS'];
//         $this->dbname = $_ENV['DBNAME'];

//         // DSN de connexion 
//         $_dsn = 'mysql:dbname=' . $this->dbname . ';host=' . $this->dbhost;

//         // On appelle le constructeur de la classe PDO
//         try {
//             parent::__construct($_dsn, $this->dbuser, $this->dbpass);

//             $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
//             $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//             $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             die($e->getMessage());
//         }
//     }

//     // Méthode qui permet de récupérer l'instance unique de la classe
//     public static function getInstance(): self
//     {
//         if (self::$instance === null) {
//             self::$instance = new self();
//         }
//         return self::$instance;
//     }
// } -->
