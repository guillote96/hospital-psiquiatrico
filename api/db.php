<?php

function getConnection() {
    try {
        $db = new PDO("mysql:dbname=base;host=localhost;charset=UTF8","root","");
    }
    catch(PDOException $e){}
    return $db;
}

function getPeople(){
	$db = getConnection();
    $stmt = $db->query("Select * from usuarios");  
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getPerson($id){
	$db = getConnection();
    $stmt = $db->prepare("Select * from usuarios where id = :id;");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function addPerson($name,$surname,$document,$pass,$status){
	$db = getConnection();
    $stmt = $db->prepare("Insert into usuarios (nombre,apellido,dni,pass,estado) values (:name,:surname,:document,:pass,:status);");
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':surname',$surname);
    $stmt->bindParam(':document',$document);
    $stmt->bindParam(':pass',$pass);
    $stmt->bindParam(':status',$status);
    $stmt->execute();
    return $stmt->rowCount();
}

function delPerson($id){
	$db = getConnection();
    $stmt = $db->prepare("Delete from usuarios where id = :id;");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    return $stmt->rowCount();
}

function updatePerson($id,$name,$surname,$document,$pass,$status){
    $db = getConnection();
    $stmt = $db->prepare("UPDATE usuarios SET nombre=:name,apellido=:surname,dni=:document,pass=:pass,estado=:status WHERE id = :id ;");
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':surname',$surname);
    $stmt->bindParam(':document',$document);
    $stmt->bindParam(':pass',$pass);
    $stmt->bindParam(':status',$status);
    $stmt->execute();
    return $stmt->rowCount();
}

?>
