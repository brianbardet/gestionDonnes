<?php
require_once 'vendor/autoload.php';

use td1\orm\Article;
use td1\orm\Categorie;

$liste = Article::all() ;
echo "Tous les noms d'articles : <br>";
foreach ($liste as $article) echo $article->nom . " " ;
echo "<br><br>";

echo "L'article avec l'id 64 : <br>";
$all = Article::first(['id', '>=', 64]);
var_dump($all);
echo "<br><br>";

echo "L'article avec l'id 65 : <br>";
$l = Article::find(65) ;
$article = $l[0] ;
var_dump($article);
echo "<br><br>";

echo "L'article (nom, tarif) avec l'id 65 : <br>";
$l = Article::find(65, ['nom','tarif']) ; // 2 colonnes
$article = $l[0] ;
var_dump($article);
echo "<br><br>";

echo "Les articles (nom, tarif) avec tarif <= 100 : <br>";
$l = Article::find( ['tarif', '<=', 100 ], ['nom', 'tarif'] ) ;
var_dump($l);
echo "<br><br>";

echo "Catégorie de l'article 65 <br>";
$a=Article::first(65);
$categorie = $a->belongs_to('categorie', 'id_categ') ;
var_dump($categorie);
echo "<br><br>";

echo "Liste article de la categorie 1 <br>";
$m = Categorie::first(1) ;
$list_article = $m->has_many('article', 'id_categ') ;
var_dump($list_article);
echo "<br><br>";

echo "Catégorie de l'article 65 <br>";
$categorie = Article::first(65)->categorie() ;
var_dump($categorie);
echo "<br><br>";

echo "Liste article de la categorie 1 <br>";
$m = Categorie::first(1)->articles;
var_dump($m);
echo "<br><br>";