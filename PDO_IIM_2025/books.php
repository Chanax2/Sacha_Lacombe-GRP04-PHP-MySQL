    <?php

    require_once("connexion.php"); // me permet de récupérer ma connexion

    ///// 
    ///// SELECT
    /////
    $stmt = $pdo->query("SELECT * FROM livres WHERE annee_publication <= '2000-12-31' ORDER BY titre ASC "); // PDO statement
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    //echo '<pre>'; 
    //var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    // la méthode fetchALL me renvoit un tableau multi dimentionnel avec tous mes enregistrements en base
    // le PDO FETCH_ASS est une constante qui me permet d'avoir en index de mes tableaux, le nom des colonnes
    //echo'</pre>';


    ///// 
    ///// EXEC
    /////

    // $sql = "INSERT INTO book (title, author, date_publication, category_idcategory) 
    // VALUES( 'Le petit prince', 'Sacha Lacombe', '1997-03-28', 1 )";

    // $pdo->exec($sql);

    ///// 
    ///// PREPARE & EXECUTE
    /////


    // try{
    //     $stmt = $pdo->prepare("INSERT INTO book (title, author, date_publication, category_idcategory) 
    //     VALUES( :title, :author, :date_publication, :category )");
        
    //     $stmt->execute([
    //         "title" => "Le rouge et le noir",
    //         "author" => "Standall",
    //         "date_publication" => "1945-01-01",
    //         "category" => 1,
    //     ]);
        
    //     $stmt->execute([
    //         "title" => "One piece",
    //         "author" => "Oda",
    //         "date_publication" => "1975-01-01",
    //         "category" => 1,
    //     ]);
    // } catch(PDOException $e) {
    //     echo $e->getMessage();
    // }


    if($_POST) {
        var_dump($_POST);
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $date_publication = $_POST["annee_publication"];

        try{
            $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, annee_publication, disponible) 
            VALUES( :titre, :auteur, :annee_publication, :disponible )");
            
            $stmt->execute([
                "titre" => "$titre",
                "auteur" => "$auteur",
                "annee_publication" => "$date_publication",
                "disponible" => 1,
            ]);

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        

        
        // if(isset($_GET['action']) && $_GET['action'] == 'delete') {
        
        //     $idbook = $_GET['id_book'];
        
        //     try {
        //         $stmt = $pdo->prepare("DELETE FROM book WHERE idbook = :idbook");
        
        //         $stmt->execute([
        //             "idbook" => $idbook,
        //         ]);
        
        //         echo "Le livre a bien été supprimé !";
        
        //     } catch (PDOException $e) {
        //         echo $e->getMessage();
        //     }
        
        // }
        
        // if(isset($_GET['action']) && $_GET['action'] == 'modify') {
        
        //     $idbook = $_GET['id_book'];
        
        //     // je récupère en bdd toutes les infos lié à cet id
        //     // faudra variabiliser le livre 
        //     // et pré-charger ses infos en dans le formulaire
        //     // ajouter un input type hidden pour stocker l'id dans le formulaire
        //     // créer un formulaire de modification
        
        //     try {
        //         $stmt = $pdo->prepare("DELETE FROM book WHERE idbook = :idbook");
        
        //         $stmt->execute([
        //             "idbook" => $idbook,
        //         ]);
        
        //         echo "Le livre a bien été supprimé !";
        
        //     } catch (PDOException $e) {
        //         echo $e->getMessage();
        //     }
        
        // }

    }


    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

        <h1>Mes livres en BDD</h1>

        <table border="1">
            <thead>

            </thead>

            <tbody>

                <?php 
                
                foreach ($books as $key => $book) {
                    echo "<tr>";
                        echo "<td>" . $book["titre"] . "</td>";
                        echo "<td>" . $book["auteur"] . "</td>";
                        echo "<td>" . $book["annee_publication"] . "</td>";
                        echo "<td>" . $book["disponible"] . "</td>";
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
        <br>
                <form method= "POST">

                <label for="titre">Titre: 
                </label>
                <input type="text" id="titre" name="titre" required>
                <label for="auteur">Auteur: </label>
                <input type="text" id="auteur" name="auteur" >
                <label for="date_publication" >date:</label>
                <input type="date" id="annee_publication" name="annee_publication" >
                

                <input type="submit" value="Créer un livre" id="submit">
                </label>
                </form>

    </body>
    </html>