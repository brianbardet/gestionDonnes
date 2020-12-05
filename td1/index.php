<?php
require_once 'vendor/autoload.php';

use td1\orm\Query;
use td1\orm\Article;

$all = Article::all();
foreach ($all as $elem){
    var_dump($elem->belongs_to("categorie","id_categ"));;
}
