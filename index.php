<?php
$username = "adminM";
$password = "pass";
$bdd = null;
$iserror_bdd = false;

try {
    $bdd = new PDO("mysql:host=localhost;dbname=mediatheque", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    $iserror_bdd = true;
}

$truc = null;
$sql = "SELECT * FROM `livres` WHERE 1";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$truc = $stmt->fetch();

if (!$iserror_bdd && $truc == null) {
// je charge les données à partir du json local
    $booksJson = file_get_contents("books.json");
    $books = json_decode($booksJson, true);


    
// Parcourir les livres et les insérer dans la table livres de la bdd
foreach ($books as $book) {
    $id = $book['id'];
    $titre = $book['titre'];
    $auteur = $book['auteur'];
    $annee = $book['annee'];
    $resume = $book['resume'];
    $image = $book['image'];

// Requête SQL pour insérer le livre dans la table "livres"
    $sql = "INSERT INTO livres (id, titre, auteur, annee, resume, image) VALUES ($id, $titre, $auteur, $annee, $resume, $image)";
        
    try {
        $bdd->exec($sql);
    } catch (PDOException $error) {
        echo "Erreur lors de l'insertion du livre " . $titre . ": " . $error->getMessage();
    }
}

// Fermeture connexion BDD
$bdd = null;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">

    <title>Bourg Palette</title>
</head>

<body>
    <header>
        <nav id="nav-header">
            <a href="index.php"><img id="logo" src="images/accueil.png" alt="Mediathèque"></a>
            <a><img id="logo2" src="images/pokeball.png" alt="compte"></a>  
        </nav>
    </header>
<div>
    <a><img id="ban" src="images/ban.png" alt="Mediathèque"></a>
</div>
<h1 id="top">La sélection</h1>
<main>
    <section class="books">
        <!-- <div class="allBooks">
            <h2></h2>
            <p></p>
            <a></a>
        </div> -->
    </section>
    <nav class="search">
        <section>
            <input type="text" class="search_bar">
        </section>
        <section class="search_book">
            <button id="searchButton">Cherchez un livre</button>
            <div class="detail">
              <!--   <div>
                    <h2>${book.titre}</h2>
                    <p>auteur: ${book.auteur}</p>
                    <p>Date de parution: ${book.date}</p>
                    <p> En bref: ${book.resume}</p>
                    <img id="img" src=${book.image} alt=${book.titre}>
                    
                    <button>Réservez-moi!</button>
                    </div>-->
            </div>
            <div class="form">
    
            </div> 
        </section>
    </nav>
    <a class="go_top" href="#top"></a>
</main>
</body>
<!-- <script src="script.js"></script> -->
<script src="getBooks.js"></script>
</html>