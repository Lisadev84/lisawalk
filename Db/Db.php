<?php

// namespace App\Db;

// //on importe PDO
// use PDO;
// use PDOException;

// class Db extends PDO                                   
// {
//     //Instance unique et privée de la classe
//     private static $instance;

//     // informations de connexion
//     // private const DBHOST = 'localhost';
//     // private const DBUSER = 'ukkr2942_Lisa';
//     // private const DBPASS = 'H$6Xa8Pc2@v@';
//     // private const DBNAME = 'ukkr2942_LisaWalk';
//    DBHOST = 'localhost';
//    DBUSER = 'ukkr2942_Lisa';
//    DBPASS = 'H$6Xa8Pc2@v@';
//    DBNAME = 'ukkr2942_LisaWalk';

//     private const DBHOST = 'localhost';
//     private const DBUSER = 'root';
//     private const DBPASS = 'X*qv#!2fmw';
//     private const DBNAME = 'Lisawalko2';


//     private function __construct()

//     {
//         //DSN de connexion 
//         $_dsn = 'mysql:dbname=' . self::DBNAME . ';host=' . self::DBHOST;

//         // On appelle le constructeur de la classe PDO
//         try {
//             parent::__construct($_dsn, self::DBUSER, self::DBPASS);

//             $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
//             $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//             $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             die($e->getMessage());
//         }
//     }
//     // méthode qui permet de récupérer l'instance unique de la classe
//     public static function getInstance(): self
//     {
//         if (self::$instance === null) {
//             self::$instance = new self();
//         }
//         return self::$instance;
//     }
// } 


namespace App\Db;

require dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;

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
        // Charger les variables d'environnement
        $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/.env', 'db.env');
        $dotenv->load();

        // Assigner les valeurs des variables d'environnement aux propriétés de la classe
        $this->dbhost = $_ENV['DBHOST'];
        $this->dbuser = $_ENV['DBUSER'];
        $this->dbpass = $_ENV['DBPASS'];
        $this->dbname = $_ENV['DBNAME'];

        // DSN de connexion 
        $_dsn = 'mysql:dbname=' . $this->dbname . ';host=' . $this->dbhost;

        // On appelle le constructeur de la classe PDO
        try {
            parent::__construct($_dsn, $this->dbuser, $this->dbpass);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
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

