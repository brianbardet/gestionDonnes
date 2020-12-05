<?php


namespace td1\orm;


class Article extends Model
{
    /**
     *  Nom de la table
     */
    protected static $table="Article";

    /**
     *  PrimaryKey de la table
     */
    protected static $primary = "id";
}