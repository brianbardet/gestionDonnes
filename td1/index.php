<?php
require_once 'vendor/autoload.php';

use td1\orm\Query;

$q = Query::table("Article");

var_dump($q);