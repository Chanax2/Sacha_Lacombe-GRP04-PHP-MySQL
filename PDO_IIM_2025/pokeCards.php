<?php 


require_once("connexion.php"); // me permet de récupérer ma connexion

///// 
///// SELECT
/////

//J'ai essayé d'afficher l'email de l'utilisateur qui a créé la carte,d'où la liason des deux tables mais ça ne marche pas :(
$cardsStmt = $pdo->query(" SELECT cards.id, cards.name, cards.type, cards.hp, user.email FROM cards LEFT JOIN user ON cards.id_user = user.iduser");
$cards = $cardsStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["iduser"] = $user["iduser"];
            $_SESSION["email"] = $user["email"];
            echo "Vous êtes connecté avec l'identifiant : " . $_SESSION["email"];
        } else {
            echo "Identifiants incorrects.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

//suppresion card
if (isset($_POST["delete_card_id"])) {
    $cardId = intval($_POST["delete_card_id"]);

    try {
        $stmt = $pdo->prepare("DELETE FROM cards WHERE id = :id");
        $stmt->execute(["id" => $cardId]);

        header("Location: pokeCards.php"); // Recharge la page après suppression pour voire le tableau updaté
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
}

//déconnexion
 if(isset($_GET["action"]) && $_GET["action"] == "deconnexion") {
    // vide la session
    unset($_SESSION["iduser"]);
    unset($_SESSION["email"]);
    header("Location: session.php");
}


//insertion de cartes
if ($_POST) {
    // Vérifie si c'est un edit ou une création gràace à "action" dans les forms
    $action = $_POST["action"] ?? null;

    if ($action === "create") {
        // Logique de création de carte
        if (isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["hp"])) {
            $name = trim($_POST["name"]);
            $type = trim($_POST["type"]);
            $hp = intval($_POST["hp"]);
            $id_user = $_SESSION["iduser"] ?? null; // Récupère l'ID de l'utilisateur connecté

            try {
                $stmt = $pdo->prepare("INSERT INTO cards (name, type, hp, id_user) VALUES (:name, :type, :hp, :id_user)");
                $stmt->execute([
                    "name" => $name,
                    "type" => $type,
                    "hp" => $hp,
                    "id_user" => $id_user,
                ]);

                header("Location: pokeCards.php");
                exit;
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            echo "Veuillez remplir tous les champs du formulaire.";
        }
    } elseif ($action === "edit") {
        // Logique de modification de carte
        if (isset($_POST["edit_card_id"])) {
            $cardId = intval($_POST["edit_card_id"]);
            $name = isset($_POST["name"]) ? trim($_POST["name"]) : null;
            $type = isset($_POST["type"]) ? trim($_POST["type"]) : null;
            $hp = isset($_POST["hp"]) ? intval($_POST["hp"]) : null;

            if ($name && $type && $hp) {
                try {
                    $stmt = $pdo->prepare("UPDATE cards SET name = :name, type = :type, hp = :hp WHERE id = :id");
                    $stmt->execute([
                        "name" => $name,
                        "type" => $type,
                        "hp" => $hp,
                        "id" => $cardId,
                    ]);

                    header("Location: pokeCards.php");
                    exit;
                } catch (PDOException $e) {
                    echo "Erreur lors de la mise à jour : " . $e->getMessage();
                }
            } else {
                echo "Veuillez remplir tous les champs pour modifier la carte.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="pokeCards.css">    
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>

<h1>Connexion</h1>

<?php if(!isset($_SESSION["iduser"])) { ?>
    <!-- Formulaire de connexion -->
    <form method="POST">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" placeholder="Email">

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" placeholder="Mot de passe">

        <input type="submit" value="Connexion">
    </form>
<?php } else { ?>
    <!-- Lien pour se déconnecter -->
    <a href="?action=deconnexion">Se déconnecter</a>
<?php } ?>

<!-- Affichage des cartes -->
<div class="cards-container">
    <?php foreach ($cards as $card): ?>
        <div class="card">
            <h3><?= htmlspecialchars($card["name"]) ?></h3>
            <p><strong>Type :</strong> <?= htmlspecialchars($card["type"]) ?></p>
            <p><strong>HP :</strong> <?= htmlspecialchars($card["hp"]) ?></p>
            <p><strong>Créé par :</strong> <?= htmlspecialchars($card["email"] ?? "Invité") ?></p>
            <div class="card-actions">
                <!-- Formulaire de suppression -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_card_id" value="<?= htmlspecialchars($card["id"]) ?>">
                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette carte ?');">Supprimer</button>
                </form>

                <!-- Bouton pour afficher le formulaire de modification -->
                <button onclick="showEditForm(<?= htmlspecialchars($card['id']) ?>, '<?= htmlspecialchars($card['name']) ?>', '<?= htmlspecialchars($card['type']) ?>', <?= htmlspecialchars($card['hp']) ?>')">Modifier</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Formulaire de création de carte -->
<form method="POST">
    <input type="hidden" name="action" value="create">
    <label for="name">Nom du pokémon à créer:</label>
    <input type="text" id="name" name="name" required>
    <label for="type">Type: </label>
    <input type="text" id="type" name="type">
    <label for="hp">HP:</label>
    <input type="number" id="hp" name="hp" required>
    <input type="submit" value="Créer une carte pokémon" id="submit">
</form>

<script>
function showEditForm(id, name, type, hp) {
    document.getElementById('editForm').style.display = 'block';
    document.getElementById('edit_card_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_type').value = type;
    document.getElementById('edit_hp').value = hp;
}

function hideEditForm() {
    document.getElementById('editForm').style.display = 'none';
}
</script>

<div id="editForm" style="display:none; margin-top:20px;">
    <h3>Modifier la carte</h3>
    <form method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="edit_card_id" id="edit_card_id">
        <label for="edit_name">Nom :</label>
        <input type="text" name="name" id="edit_name" required>
        <label for="edit_type">Type :</label>
        <input type="text" name="type" id="edit_type" required>
        <label for="edit_hp">HP :</label>
        <input type="number" name="hp" id="edit_hp" required>
        <button type="submit">Enregistrer</button>
        <button type="button" onclick="hideEditForm()">Annuler</button>
    </form>
</div>

</body>
</html>