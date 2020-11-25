<?php
namespace td1\orm;
use PDO;
use PDOException;

require_once 'vendor/autoload.php';

class ConnectionFactory {

    /**
     * Connection à la db
     */
    protected static $connection;

    /**
     * Création de la connection à la db
     * @param $conf
     * @return PDO
     */
    public static function makeConnection($conf){

        $user = $conf['user'];
        $pass = $conf['pass'];
        $name = $conf['name'];
        $host = $conf['host'];
        $type = $conf['type'];

        try {
            $dsn = "$type:dbname=$name;host=$host";
            ConnectionFactory::$connection = new PDO($dsn, $user, $pass,array(
                PDO::ATTR_PERSISTENT => true
            ));
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }

        return ConnectionFactory::$connection;
    }

    public static function getConnection(){
        return ConnectionFactory::$connection;
    }

}