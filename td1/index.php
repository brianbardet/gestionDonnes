<?php
require_once 'vendor/autoload.php';

use td1\orm\Article;
use td1\orm\Categorie;
$all = Article::find([['id', '>=', 64],['nom', 'like', '%v%l%']], ['id', 'nom']);

var_dump($all);
