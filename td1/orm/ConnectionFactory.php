<?php
namespace td1;
require_once 'vendor/autoload.php';

class ConnectionFactory {

    /**
     * Connection à la db
     */
    protected static $connection;

    /**
     * Création de la connection à la db
     * @param Array conf configuration
     */
    public static function makeConnection(array $conf){

        $user = $conf['user'];
        $pass = $conf['pass'];
        $name = $conf['name'];
        $host = $conf['host'];
        $type = $conf['type'];

        try {
            $dsn = "$type:dbname=$name;host=$host";
            $connection = new PDO($dsn, $user, $pass,array(
                PDO::ATTR_PERSISTENT => true
            ));
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        
    }

    public static function getConnection(){
        return $connection;
    }

}