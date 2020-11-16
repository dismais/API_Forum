<?php

	class Database{
	
    // Connexion à la base de données
    
    private $host = "localhost";
    private $db_name = "posts_db";
    private $username = "admin";
    private $password = "";
    public $connexion;

    // attendre la connexion
    
    public function getConnection(){

        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connexion->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->connexion;
    }   
?>
