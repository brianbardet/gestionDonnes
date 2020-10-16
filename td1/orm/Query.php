<?php
namespace td1\orm;
require_once 'vendor/autoload.php';
use td1\orm\ConnectionFactory;

class Query {

    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = [];
    private $sql = '';
    private $connection;
    
    public static function table($table) {
        $query = new Query;
        $query->sqltable= $table;
        $connection = ConnectionFactory::makeConnection(parse_ini_file('../conf/db.conf.ini'));
        return $query;
    }
    
    public function select($fields) {
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
        if(isset($this->where)){
            foreach($this->where as $cond){
                $this->sql .= ' where ' . $cond[0] . ' ' . $cond[1] . ' :' . $key;
                $this->args[':'.$key] = $cond[2]; 
            }
        }

        //Préparation + Execution
        $stmt = $this->connection->prepare($this->sql);
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
        $stmt = $this->connection->prepare($this->sql);
        $stmt->execute($this->args);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * PAram type nameofcolumn => value
     * @param $param
     * @return mixed
     */
    public function insert($param){
        //SQL de base 
        $col = "";
        $val = "";
        foreach($param as $key => $val){
            $col .= $key . ',';
            $val .= $val . ',';
        }
        $this->sql = 'insert into '. $this->sqltable . ' (' . $col . ') Values (' . $val . ')';
        $stmt = $this->connection->prepare($this->sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}