<?php


namespace td1\orm;


class Article extends Model
{
    /**
     *  Nom de la table
     */
    protected static $table="article";

    /**
     *  PrimaryKey de la table
     */
    protected static $primary = "id";

    public function categorie(){
        return $this->belongs_to("categorie","id_categ");
    }

    public function __get($attr_name) {
        if(array_key_exists($attr_name, $this->_v)){
            return $this->_v[$attr_name];
        }else{
            if($attr_name == "categorie"){
                return $this->categorie();
            }
        }
    }
}