<?php
require_once '../classes/Pokemon.php';

// Démarrage de la session
session_start();


// Vérification de l'existence des données de session
if (!isset($_SESSION['game_mode'])) {
    echo "Game mode not set.";
    exit;
}

if (!isset($_SESSION['selected_pokemon'])) {
    echo "No Pokémon selected.";
    exit;
}

// Récupération des données de session
$gameMode = $_SESSION['game_mode'];
$selectedPokemon = $_SESSION['selected_pokemon'];
$opponent = $_SESSION['opponent'];

$pv = $selectedPokemon->health;
$pvAdversaire = $opponent->health;

if ($pv <= 0) {
    $_SESSION['issue'] = "lose";
    header("Location: fin.php");
    exit;
}
if ($pvAdversaire <= 0) {
    $_SESSION['issue'] = "win";
    header("Location: fin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Interface de Combat</title>
    <link rel="stylesheet" href="../assets/fight.css">
</head>

<body>
    <div class="top">
        <div class="player">
        <h1><?php echo htmlspecialchars($selectedPokemon->name); ?></h1>

            <img src=<?php echo $selectedPokemon->sprite ?> alt="sprite" >
            <h2><?php echo htmlspecialchars($selectedPokemon->health)."/". $_SESSION['maxhealth']." PV(s)"; ?></h2>
            <p><?php echo htmlspecialchars($selectedPokemon->type); ?></p>
            <p>Atk: <?php echo htmlspecialchars($selectedPokemon->attack); ?></p>
            <p>Def: <?php echo htmlspecialchars($selectedPokemon->defense); ?></p>
        </div>
        <div class="opponent">
            <h1> <?php echo htmlspecialchars($opponent->name) ?></h1>
            <img src=<?php echo $opponent->sprite ?> alt="sprite" >
            <h2><?php echo htmlspecialchars($opponent->health)." PV(s)"?></h2>
            <p><?php echo htmlspecialchars(string: $opponent->type) ?></p>
            <p>Atk: <?php echo htmlspecialchars($opponent->attack) ?></p>
            <p>Def: <?php echo htmlspecialchars($opponent->defense) ?></p>
        </div>
    </div> 
    
    <div class="botbattle">
    <div class="message">
    <?php
        if (isset($_SESSION['battle_message'])) {
            echo $_SESSION['battle_message'];
        } ?>
    </div>
        <form method="post" action="../classes/Attaque.php">
            <button type="submit" name="action" value="charge">Charge</button>
            <button class="vert" type="submit" name="action" value="<?php echo htmlspecialchars($selectedPokemon->type) ?>">
                <?php echo htmlspecialchars($selectedPokemon->move); ?>
            </button>
        </form>
    </div>
</body>

</html>