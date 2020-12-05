<?php
require_once 'vendor/autoload.php';

use td1\orm\Article;
use td1\orm\Categorie;
$all = Categorie::all()[0];
var_dump($all->articles);
