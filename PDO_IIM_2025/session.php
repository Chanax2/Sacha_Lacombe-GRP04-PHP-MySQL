<?php

require_once("connexion.php");

// if($_POST){

//     $email = $_POST["email"];
//     $password = $_POST["password"];

//     $sql = "POST INTO user (email, password) VALUES(:email, :password)";

//     $stmt = $pdo->prepare($sql);
//     // $stmt->execute([
//     //     'email' => $email,
//     //     'password' => password_hash($password, PASSWORD_DEFAULT)
//     // ]);

//     echo "Votre user a été correctement inséré en BDD";

// }

if($_POST) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email && $password) {
        $stmt = $pdo->query("SELECT * FROM user WHERE email = '$email' ");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["iduser"] = $user["iduser"];
            $_SESSION["email"] = $user["email"];
            
            echo "Vous êtes connecté avec l'identifiant : " . $_SESSION["email"];
        } else {
            echo "Identifiants incorrects.";
        }
    }
 }


 if(isset($_GET["action"]) && $_GET["action"] == "deconnexion") {
    // je vide ma session
    unset($_SESSION["iduser"]);
    unset($_SESSION["email"]);
    header("Location: pokeCards.php");
}

?>




<?php

// DIAPO 87-97
// session_start()

// si j'ai un post
// je récupère email et password
// je récupère les infos du user en bdd pour cet email
// SELCT ... WHERE email = ...
// je variabilise avec un fetch

// je vérifie si le mot de passer de mon form et celui en bdd sont les même
// password_verify

// si c'est le cas
// j'alimente ma session avec l'id, l'email en sesssion

// message de confirmation : vous êtes connecté avec l'identifiant : email@mail.com

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Connexion</h1>

    <?php if(!isset($_SESSION["iduser"]) ) { ?>
        <form method="POST">

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" placeholder="Email">


            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe">

            <input type="submit" value="Connexion">

        </form>
    
    <?php } else { ?>

        <a href="?action=deconnexion">Se déconnecter</a>

    <?php } ?>


    
</body>

</html>