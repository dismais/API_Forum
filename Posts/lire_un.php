
<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Posts.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les posts
    $post = new Posts($db);

    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $post->id = $donnees->id;

        // On récupère le post
        $post->lireUn();

        // On vérifie si le post existe
        if($post->nom != null){

            $p = [
                "id" => $post->id,
                "author" => $post->author,
                "content" => $post->content,
                "date" => $post->date,
                "topic_id" => $post->topic_id,
                "topic_title" => $post->topic_title
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($p);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "Le post n'existe pas."));
        }
        
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
