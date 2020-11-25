<?php
// This path should point to Composer's autoloader
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://brian:brian@localhost:27017");

//Récupération DB
$db = $client->firstmongodb;

var_dump($db);