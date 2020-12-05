<?php


namespace td1\orm;


class Categorie extends Model
{
    /**
     *  Nom de la table
     */
    protected static $table="categorie";

    /**
     *  PrimaryKey de la table
     */
    protected static $primary = "id";

    public function articles(){
        return $this->has_many("article","id_categ");
    }

    public function __get($attr_name) {
        if(array_key_exists($attr_name, $this->_v)){
            return $this->_v[$attr_name];
        }else{
            if($attr_name == "articles"){
                return $this->articles();
            }
        }
    }
}