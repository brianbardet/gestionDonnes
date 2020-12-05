<?php
require_once 'vendor/autoload.php';

use td1\orm\Article;
use td1\orm\Categorie;
$all = Article::first(['id', '>=', 64]);

var_dump($all);
