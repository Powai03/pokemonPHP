<?php
require_once '../classes/Pokemon.php';

// Démarrage de la session
session_start();

// Si le mode de jeu est envoyé, l'ajouter à la session
if (isset($_POST['mode'])) {
    $_SESSION['game_mode'] = $_POST['mode'];
}
$_SESSION['nbAttaque'] = 0;
$_SESSION['degats'] = 0;
$_SESSION['degatsAdversaire'] = 0;
$_SESSION['nbAdversaireVaincu'] = 0;

// Récupération de la session pour le mode de jeu
$gameMode = isset($_SESSION['game_mode']) ? $_SESSION['game_mode'] : 'Mode inconnu';

// Récupération de la liste des Pokémon disponibles
$pokemonList = Pokemon::getAllPokemon();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon_id'])) {
    $selectedPokemonId = $_POST['pokemon_id'];
    // Enregistrer le Pokémon sélectionné dans la session
    $_SESSION['selected_pokemon'] = $pokemonList[$selectedPokemonId];
    $selectedPokemon = $pokemonList[$selectedPokemonId];
    $_SESSION['maxhealth'] = $selectedPokemon->health;
    //Récuperation des adversaires possibles en retirant le pokémon choisi
$opponent = array_filter(Pokemon::getAllPokemon(), function($pokemon) use ($selectedPokemon) {
    return $pokemon->name !== $selectedPokemon->name;
});
// Mélange les positions des Pokémon adversaires aléatoirement (notamment pour le mode de jeu "Tournoi")
shuffle($opponent);

//Définit l'adversaire en fonction du mode de jeu
if ($gameMode === 'Exhibition') {
    $opponent = array($opponent[array_rand($opponent)]); //on pourrait juste prendre le premier car le tableau est déjà mélangé mais on garde l'aléatoire parce que j'en ai envie :)
    echo "Adversaire : <br>";
    echo htmlspecialchars($opponent[0]->name) . "<br>";
    $_SESSION['opponent'] = $opponent[0];
} else {
    echo "Adversaires : <br>";
    foreach ($opponent as $pokemon) {
        echo htmlspecialchars($pokemon->name) . "<br>";
    }
    $_SESSION['opponent'] = $opponent;
}
    // Redirection vers la page de combat
    if($gameMode === 'Tournoi'){
        header('Location: interfaceTournoi.php');
    } else {
        header('Location: interfaceCombat.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choix du Pokémon</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Mode de jeu: <?php echo htmlspecialchars($gameMode); ?></h1>
    <h2>Choisissez votre Pokémon</h2>
    <div class="choix">
    <?php foreach ($pokemonList as $index => $pokemon): ?>
        <form method="post" action="choixPokemon.php" >
            <input type="hidden" name="pokemon_id" value="<?php echo $index; ?>">
            <img src=<?php echo $pokemon->sprite ?> alt="sprite" style="width:50px">

            <button type="submit"><?php echo htmlspecialchars($pokemon->name); ?></button>
        </form>
    <?php endforeach; ?>
    </div>
    <form method="post" action="choixPokemon.php" style="display:inline;">
        <input type="hidden" name="pokemon_id" value="<?php echo htmlspecialchars(array_rand($pokemonList)); ?>">
        <button type="submit">Choisir un Pokémon aléatoire</button>
    </form>
    <a href="index.php">Retour en arrière</a>

</body>
</html>
