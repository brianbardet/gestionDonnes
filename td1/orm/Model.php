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
        //if(array_key_exists($attr_name, $this->_v))
            $this->_v[$attr_name] = $value;
    }

    public function delete() {
        if(array_key_exists(static::$primary, $this->_v))
            if(!is_null($this->_v[static::$primary])) {
                return Query::table(static::$table)
                    ->where(static::$primary, '=', $this->_v[static::$primary])
                    ->delete();
            }
    }

    public function insert() {
        $all = Query::table(static::$table)->insert($this->_v);
        $new = end($all);
        $this->_v[static::$primary] = $new[static::$primary];
        return $this;
    }

    public static function all(){
        $all = Query::table(static::$table)->select(['*'])->get();
        $tab=[];
        foreach ( $all as $elem ){
            $tab[] = new static($elem);
        }
        return $tab;
    }

    public static function find($id=null, $columns=null){
        $args = ['*'];
        if($columns!=null && is_array($columns)) $args = $columns;
        if($id!=null && is_int($id))
            $query = Query::table(static::$table)->select($args)->where(self::$primary, "=", $id);
        else
            $query = Query::table(static::$table)->select($args);
        $result = $query->get();
        $tab=[];
        foreach ( $result as $elem ){
            $tab[] = new static($elem);
        }
        return $tab;
    }

    public function belongs_to($table, $champ){
        $id = $this->__get($champ);
        $res = Query::table($table)->select(['*'])->where(Model::$primary, "=",$id)->get();
        return new Model($res[0]);
    }

    public function has_many($table, $champ){

    }
}