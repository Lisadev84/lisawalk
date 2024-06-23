<?php

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

