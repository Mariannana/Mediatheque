<?php
$username = "adminM";
$password = "pass";
$bdd = null;
$iserror_bdd = false;

try {
    $bdd = new PDO("mysql:host=localhost;dbname=mediatheque", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    http_response_code(500);
    echo json_encode($error->getMessage());
}


///////////////////////////////////
// var_dump($_POST);

// Récupération des données du formulaire
if(isset($_POST["submit"])){
$id_livre = $_POST['id_livre'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail = $_POST['mail'];


// Insertion de la réservation dans la table de réservation
$sql = "INSERT INTO reservations (id_livre, nom, prenom, mail) VALUES (:id_livre, :nom, :prenom, :mail)";

try {
    $stmt = $bdd->prepare($sql);

    $stmt->bindParam(':id_livre', $id_livre);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    echo json_encode("Réservation Ok");
} catch (PDOException $error) {
    http_response_code(500);
    echo json_encode($error->getMessage());
}



}


 ?>


