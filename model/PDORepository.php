<?php

abstract class PDORepository {
    
  const USERNAME = "root";
    const PASSWORD = "";
	const HOST ="localhost";
	const DB = "grupo2";
    
    /*const USERNAME = "grupo2";
    const PASSWORD = "MzhjMzZiMTI4Y2Q0";
    const HOST ="localhost";
    const DB = "grupo2";*/
    
    private function getConnection(){
        $u=self::USERNAME;
        $p=self::PASSWORD;
        $db=self::DB;
        $host=self::HOST;
        $connection = new PDO("mysql:dbname=$db;host=$host", $u, $p);
        return $connection;
    }
    
    protected function queryList($sql){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    protected function addObj($sql){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt-> execute();
    }

    protected function query($sql,$array){
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($array);
        return $stmt->fetchAll();
    }
    
}
