<?php

class Usuario {
    
   private $id;   
   private $email;
   private $username;    
   private $password;    
   private $activo;  
   private $updated_at;  
   private $created_at;  
   private $first_name;  
   private $last_name;
   private $rol;


    
    public function __construct($id, $email, $username, $activo,$password,$updated_at,$created_at, $first_name, $last_name) {
        $this->id = $id;   
        $this->email = $email;
        $this->username= $username;    
        $this->password= $password;    
        $this->activo = $activo;  
        $this->updated_at = $updated_at;  
        $this->created_at = $created_at;  
        $this->first_name = $first_name;  
        $this->last_name = $last_name;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getActivo() {
        return $this->activo;
    }
    public function getUpdateAt() {
        return $this->updated_at;
    }
    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }
}
