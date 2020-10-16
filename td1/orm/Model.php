<?php

namespace td1\orm;
require_once 'vendor/autoload.php';

class Model
{
    /**
     *  Nom de la table
     */
    protected static $table;

    /**
     *  PrimaryKey de la table
     */
    protected static $primary = "id";

    /**
     *  attributs de la table
     */
    protected $_v = [];

    public function __construct(array $t = null)
    {
        if(!is_null($t)) $this->_v = $t;
    }

    public function __get($attr_name) {
        if(array_key_exists($attr_name, $this->_v))
            return $this->_v[$attr_name];
    }

    public function __set($attr_name, $value) {
        if(array_key_exists($attr_name, $this->_v))
            $this->_v[$attr_name] = $value;
    }

    public function delete() {
        if(array_key_exists(static::$primary, $this->_v))
            if(!is_null($this->_v[static::$primary])) {
                return Query::table(static::table)
                    ->where(static::primary, '=', $this->_v[static::primary])
                    ->delete();
            }
    }

    public static function all(){
        $all = Query::table(static::table)->get();
        $tab=[];
        foreach ( $all as $elem ){
            $tab[] = new static($elem);
        }
        return $tab;
    }
}