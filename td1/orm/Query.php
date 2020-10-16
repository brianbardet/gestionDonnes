<?php
namespace td1;
require_once 'vendor/autoload.php';

class Query {

    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';
    private $connection;
    
    public static function table( string $table) {
        $query = new Query;
        $query->sqltable= $table;
        return $query;
    }
    
    public function select( array $fields) {
        $this->fields = implode( ',', $fields);
        return $this;
    }

   public function where($col, $op, $val) {
        $where[] = [$col,$op,$val];
        return $this;
   }

   public function get() {
        //SQL de base
        $this->sql = 'select '. $this->fields .
                     ' from ' . $this->sqltable;

        //Gestion where
        if(isset($where)){
            foreach($where as $cond){
                $this->sql .= ' where ' . $cond[0] . ' ' . $cond[1] . ' :' . $key;
                $this->args[':'.$key] = $cond[2]; 
            }
        }

        //Préparation + Execution
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function delete() {
        //SQL de base
        $this->sql = 'delete from '. $this->sqltable;

        //Gestion where
        if(isset($where)){
            foreach($where as $cond){
                $this->sql .= ' where ' . $cond[0] . ' ' . $cond[1] . ' :' . $key;
                $this->args[':'.$key] = $cond[2]; 
            }
        }

        //Préparation + Execution
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * PAram type nameofcolumn => value
     */
    public function insert(array $param){
        //SQL de base 
        $col = "";
        $val = "";
        foreach($param as $key => $val){
            $col .= $key . ',';
            $val .= $val . ',';
        }
        $this->sql = 'insert into '. $this->sqltable . ' (' . $col . ') Values (' . $val . ')';
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}