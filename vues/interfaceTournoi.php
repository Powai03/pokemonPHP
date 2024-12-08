<?php
require_once '../classes/Pokemon.php';

// Démarrage de la session
session_start();

// Vérification des données nécessaires
if (!isset($_SESSION['selected_pokemon']) || !isset($_SESSION['opponent']) || empty($_SESSION['opponent'])) {
    echo "Erreur : données manquantes ou aucun adversaire disponible. Veuillez recommencer le tournoi.";
    exit;
}

// Récupération des données
$playerPokemon = $_SESSION['selected_pokemon']; // Votre Pokémon
$opponents = $_SESSION['opponent'];           // Liste des adversaires
$currentOpponent = reset($opponents);          // Premier adversaire de la liste

// Initialisation des soins si non définis
if (!isset($_SESSION['heals_used'])) {
    $_SESSION['heals_used'] = 0;
}
if ($playerPokemon->health <= 0) {
    $_SESSION['issue'] = "lose";
    header("Location: fin.php");
    exit;
}
// Récupération du message de combat
$battleMessage = isset($_SESSION['battle_message']) ? htmlspecialchars($_SESSION['battle_message']) : 'Aucun message pour l\'instant.';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Interface de Tournoi</title>
    <link rel="stylesheet" href="../assets/fight.css">

</head>

<body>
    <div class="top">

        <div class="player">
            <h1><?php echo htmlspecialchars($playerPokemon->name); ?></h1>
            <img src="<?php echo htmlspecialchars($playerPokemon->sprite); ?>" alt="sprite">
            <h2><?php echo htmlspecialchars($playerPokemon->health) . "/" . $_SESSION['maxhealth'] . " PV(s)"; ?></h2>
            <p> <?php echo htmlspecialchars($playerPokemon->type); ?></p>
            <p>Atk: <?php echo htmlspecialchars($playerPokemon->attack); ?></p>
            <p>Def: <?php echo htmlspecialchars($playerPokemon->defense); ?></p>
        </div>

        <div class="opponent">
            <h1> <?php echo htmlspecialchars($currentOpponent->name) ?></h1>
            <img src="<?php echo htmlspecialchars($currentOpponent->sprite); ?>" alt="sprite">
            <h2><?php echo htmlspecialchars($currentOpponent->health) . " PV(s)"; ?></h2>
            <p> <?php echo htmlspecialchars($currentOpponent->type); ?></p>
            <p>Atk: <?php echo htmlspecialchars($currentOpponent->attack); ?></p>
            <p>Def: <?php echo htmlspecialchars($currentOpponent->defense); ?></p>
        </div>
    </div>
    <div class="botbattle">
        <div class="message">
            <p>Nombre d'adversaires restants: <?php echo count($opponents); ?></p>
            <p><?php
            if (isset($battleMessage)) {
                echo $battleMessage;
            } ?></p>
        </div>
    
    <div>
        <form method="post" action="../classes/Tournoi.php">
            <button type="submit" name="action" value="charge">Charge</button>
            <button class="spe" type="submit" name="action" value="<?php echo htmlspecialchars($playerPokemon->type); ?>">
                <?php echo htmlspecialchars($playerPokemon->move); ?>
            </button>
            <?php if ($_SESSION['heals_used'] < 3) {
                echo '<button class="vert" type="submit" name="action" value="heal">Soin</button>';
            } ?>
        </form>
    </div>
    </div>
</body>

</html>