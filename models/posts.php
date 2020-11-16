<?php
class Posts{
	// Connexion
	private $connexion;
	
	private $table = "posts";

	// object properties
	public $id;
	public $author;
	public $content;
	public $date;
	public $topic_id;
	public $topic_title;

	// consturction de la connexion DB
    
	public function __construct($db){
    	$this->connexion = $db;
	}

	// lecture des posts
    
	public function lire(){
   	 
    	// ECRITUTRE DE LA REQUETE
    	$sql = "SELECT t.title AS topic_title, p.id, p.topic_id, p.content, p.author, p.date FROM " . $this->table . " p LEFT JOIN topics t ON p.topic_id = t.id ORDER BY p.date DESC";

    	// PREPARATION DE LA REQUETE
    	$query = $this->connexion->prepare($sql);

    	// EXECUTION DE LA REQUETE
    	$query->execute();

    	// RETOUR DE LA REQUETE
    	return $query;
	}
    
	// lire un post
    
	public function lireUn(){
   	 
    	// REQUETE SQL
    	$sql = "SELECT t.title as topic_title, p.id, p.author, p.content, p.topic_id, p.date FROM " . $this->table . " p LEFT JOIN topics c ON p.topics_id = t.id WHERE p.id = ? LIMIT 0,1";

    	// PREPARATION DE LA REQUETE
    	$query = $this->connexion->prepare( $sql );

    	// ID
    	$query->bindParam(1, $this->i);

    	// EXECUTION DE LA REQUETE
    	$query->execute();

    	// RECUP DE LA LIGNE
    	$row = $query->fetch(PDO::FETCH_ASSOC);

    	// HYDRATE L'OBJET
    	$this->author = $row['author'];
    	$this->content = $row['content'];
    	$this->topic_id = $row['topic_id'];
    	$this->topic_title = $row['topic_title'];
    	$this->date = $row['date'];


	}

    
	// creer un post
    
    	public function creer(){

    	// REQUETE SQL
    	$sql = "INSERT INTO " . $this->table . " SET author=:author, content=:centent, topic_id=:topic_id, date=:date";

    	// PREPARATION DE LA REQUETE
    	$query = $this->connexion->prepare($sql);

    	// PROTECTION CONTRE LES INJECTIONS
    	$this->author=htmlspecialchars(strip_tags($this->author));
    	$this->content=htmlspecialchars(strip_tags($this->content));
    	$this->topic_id=htmlspecialchars(strip_tags($this->topic_id));
    	$this->date=htmlspecialchars(strip_tags($this->date));

    	// AJOUT DES DONNÉES SECURISÉ
    	$query->bindParam(":athor", $this->author);
    	$query->bindParam(":content", $this->content);
    	$query->bindParam(":topic_id", $this->topic_id);
    	$query->bindParam(":date", $this->date);

    	// EXECUTION DE LA REQUETE
    	if($query->execute()){
        	return true;
    	}
    	return false;
	}
    
	// supprimer un post
    
	public function supprimer(){
   	 
    	// REQUETE SQL
    	$sql = "DELETE FROM " . $this->table . " WHERE id = $id";

    	// PREPARATION
    	$query = $this->connexion->prepare( $sql );

    	// SECURISATION DES DONNÉES
    	$this->id=htmlspecialchars(strip_tags($this->id));

    	// ATTACHEMENT DE LA VARIABLE ID
    	$query->bindParam(1, $this->id);

    	// EXECUTION
    	if($query->execute()){
        	return true;
    	}
   	 
    	return false;
	}
    
    
    // Mettre à jour un post
 
 
    public function modifier(){
    
        // ROQUETE SQL
        $sql = "UPDATE " . $this->table . " SET author = :author, content = :content, date = :date, topic_id = :topic_id WHERE id = :id";
        
        // PREPARATION
        $query = $this->connexion->prepare($sql);
        
        // SECURISATION
        $this->author=htmlspecialchars(strip_tags($this->author));
        $this->content=htmlspecialchars(strip_tags($this->content));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->topic_id=htmlspecialchars(strip_tags($this->topic_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        // ATTACHEMENT DES VARIABLES
        $query->bindParam(':author', $this->author);
        $query->bindParam(':content', $this->content);
        $query->bindParam(':date', $this->date);
        $query->bindParam(':topic_id', $this->topic_id);
        $query->bindParam(':id', $this->id);
        
        // EXECUTION
        if($query->execute()){
            return true;
        }
        
        return false;
    }
    
    
    
}

?>





