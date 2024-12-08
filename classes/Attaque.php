<?php
require_once '../classes/Pokemon.php';

// Démarrage de la session
session_start();



// Vérification des données de session nécessaires
if (!isset($_SESSION['selected_pokemon']) || !isset($_SESSION['opponent'])) {
    echo "Erreur : Pokémon ou adversaire non défini.";
    exit;
}

// Récupération des Pokémon en combat
$playerPokemon = $_SESSION['selected_pokemon'];
$opponent = $_SESSION['opponent'];

// Récupération de l'action choisie par le joueur
$action = isset($_POST['action']) ? $_POST['action'] : null;

if (!$action) {
    echo "Aucune action sélectionnée.";
    exit;
}

// Fonction pour calculer les dégâts
function calculateDamage($attacker, $defender) {
    // Base des dégâts (ajustez selon votre logique)
    $attack = $attacker->attack;
    $defense = $defender->defense;
    $damage = max(5, $attack - $defense); // Les dégâts ne peuvent pas être négatifs
    return $damage;
}

// Gestion de l'attaque
if ($action === 'charge') {
    // Attaque basique
    $damage = calculateDamage($playerPokemon, $opponent);
    $opponent->health -= $damage;
    $message = $playerPokemon->name . " utilise Charge et inflige $damage dégâts !";
    $_SESSION['nbAttaque']++;
    $_SESSION['degats'] += $damage;
} else {
    // Attaque spéciale de type
    if ($opponent->type === $playerPokemon->strong || $opponent->weak === $playerPokemon->type) {
        $damage = calculateDamage($playerPokemon, $opponent) * 2;
        $message = $playerPokemon->name . " utilise une attaque de type " . htmlspecialchars($playerPokemon->type) . " et inflige $damage dégâts ! Super efficace !";

    } elseif ($opponent->type === $playerPokemon->weak || $opponent->strong === $playerPokemon->type) {
        $damage = floor(calculateDamage($playerPokemon, $opponent) / 2);
        $message = $playerPokemon->name . " utilise une attaque de type " . htmlspecialchars($playerPokemon->type) . " et inflige $damage dégâts ! Pas très efficace !";

    } else {
        $damage = calculateDamage($playerPokemon, $opponent);
        $message = $playerPokemon->name . " utilise une attaque de type " . htmlspecialchars($playerPokemon->type) . " et inflige $damage dégâts !";

    }
    $opponent->health -= $damage;
    $_SESSION['nbAttaque']++;
    $_SESSION['degats'] += $damage;
}

// L'adversaire attaque
if ($opponent > 0) {
    

$opponentAction = rand(0, 1) === 0 ? 'charge' : 'special';

if ($opponentAction === 'charge') {
    // Attaque basique de l'adversaire
    $damage = calculateDamage($opponent, $playerPokemon);
    $playerPokemon->health -= $damage;
    $message .= " " . $opponent->name . " utilise Charge et inflige $damage dégâts !";
    $_SESSION['degatsAdversaire'] += $damage;
} else {
    // Attaque spéciale de type de l'adversaire
    if ($playerPokemon->weak === $opponent->type || $playerPokemon->type === $opponent->strong) {
        $damage = calculateDamage($opponent,$playerPokemon) * 2;
        $message .= " " . $opponent->name . " utilise une attaque de type " . htmlspecialchars($opponent->type) . " et inflige $damage dégâts ! Super efficace !";

    } elseif ($playerPokemon->strong === $opponent->type || $playerPokemon->type === $opponent->weak) {
        $damage = floor(calculateDamage($opponent,$playerPokemon) / 2);
        $message .= " " . $opponent->name . " utilise une attaque de type " . htmlspecialchars($opponent->type) . " et inflige $damage dégâts ! Pas très efficace !";

    } else {
        $damage = calculateDamage($opponent, $playerPokemon);
        $message .= " " . $opponent->name . " utilise une attaque de type " . htmlspecialchars($opponent->type) . " et inflige $damage dégâts !";

    }
    $playerPokemon->health -= $damage;
    $_SESSION['degatsAdversaire'] += $damage;
}
}
// Mise à jour des données de session
$_SESSION['selected_pokemon'] = $playerPokemon;


// Mise à jour des données de session
$_SESSION['opponent'] = $opponent;

// Redirection vers la page de combat avec le message
$_SESSION['battle_message'] = $message;
header('Location: ../vues/interfaceCombat.php');
exit;
?>
