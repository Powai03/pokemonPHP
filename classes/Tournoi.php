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
$playerPokemon = $_SESSION['selected_pokemon'];
$opponents = $_SESSION['opponent'];
$currentOpponent = reset($opponents); // Premier adversaire

// Récupération de l'action
$action = isset($_POST['action']) ? $_POST['action'] : null;
if (!$action) {
    echo "Aucune action sélectionnée.";
    exit;
}

// Fonction pour calculer les dégâts
function calculateDamage($attacker, $defender) {
    $attack = $attacker->attack;
    $defense = $defender->defense;
    return max(5, $attack - $defense); // Dégâts minimum : 5
}

// Gestion des actions
$message = '';
if ($action === 'charge') {
    // Attaque de base
    $damage = calculateDamage($playerPokemon, $currentOpponent);
    $currentOpponent->health -= $damage;
    $message .= $playerPokemon->name . " inflige $damage dégâts avec Charge !";
    $_SESSION['degats'] += $damage;

} elseif ($action === 'heal' && $_SESSION['heals_used'] < 3) {
    // Soin : Ne s'applique que si les soins sont encore disponibles
    $healAmount = rand(20, 40);
    $playerPokemon->health += $healAmount;
    if ($playerPokemon->health > $_SESSION['maxhealth']) {
        $playerPokemon->health = $_SESSION['maxhealth'];
    }
    $_SESSION['heals_used']++; // Incrémenter le nombre de soins utilisés
    $message .= $playerPokemon->name . " est soigné de $healAmount PV !";

} elseif ($action === $playerPokemon->type) {
    // Attaque de type
    if ($currentOpponent->weak === $playerPokemon->type || $currentOpponent->type === $playerPokemon->strong) {
        $damage = calculateDamage($playerPokemon, $currentOpponent) * 2;
        $message = $playerPokemon->name . " utilise une attaque de type " . htmlspecialchars($playerPokemon->type) . " et inflige $damage dégâts ! Super efficace !";

    } elseif ($currentOpponent->strong === $playerPokemon->type || $currentOpponent->type === $playerPokemon->weak) {
        $damage = floor(calculateDamage($playerPokemon, $currentOpponent) / 2);
        $message = $playerPokemon->name . " utilise une attaque de type " . htmlspecialchars($playerPokemon->type) . " et inflige $damage dégâts ! Pas très efficace !";

    } else {
        $damage = calculateDamage($playerPokemon, $currentOpponent);
        $message = $playerPokemon->name . " utilise une attaque de type " . htmlspecialchars($playerPokemon->type) . " et inflige $damage dégâts !";

    }
    $currentOpponent->health -= $damage;
    $_SESSION['degats'] += $damage;

}

// Adversaire riposte
if ($currentOpponent->health > 0) {
    $opponentAction = rand(0, 1) === 0 ? 'charge' : 'special';
    if ($opponentAction === 'charge') {
        $damage = calculateDamage($currentOpponent, $playerPokemon);
        $playerPokemon->health -= $damage;
        $message .= " " . $currentOpponent->name . " inflige $damage dégâts avec charge.";
        $_SESSION['degatsAdversaire'] += $damage;
    } else {
        
        if ($playerPokemon->weak === $currentOpponent->type || $playerPokemon->type === $currentOpponent->strong) {
            $damage = calculateDamage($currentOpponent,$playerPokemon) * 2;
            $message .= " " . $currentOpponent->name . " utilise une attaque de type " . htmlspecialchars($opponent->type) . " et inflige $damage dégâts ! Super efficace !";
    
        } elseif ($playerPokemon->strong === $currentOpponent->type || $playerPokemon->type === $currentOpponent->weak) {
            $damage = floor(calculateDamage($currentOpponent,$playerPokemon) / 2);
            $message .= " " . $currentOpponent->name . " utilise une attaque de type " . htmlspecialchars($opponent->type) . " et inflige $damage dégâts ! Pas très efficace !";
    
        } else {
            $damage = calculateDamage($currentOpponent, $playerPokemon);
            $message .= " " . $currentOpponent->name . " utilise une attaque de type " . htmlspecialchars($opponent->type) . " et inflige $damage dégâts !";
    
        }
        $playerPokemon->health -= $damage;
        $_SESSION['degatsAdversaire'] += $damage;
    }
} else {
    // Si l'adversaire est vaincu
    array_shift($opponents); // Retirer l'adversaire vaincu
    $_SESSION['opponent'] = $opponents;
    $_SESSION['nbAdversaireVaincu']++; // Incrémenter le nombre d'adversaires vaincus
    if (empty($opponents)) {
        // Si tous les adversaires sont vaincus
        $_SESSION['battle_message'] = $message . " Tournoi terminé, vous avez gagné !";
        header('Location: ../vues/fin.php');
        exit;
    }
}

// Mise à jour des données
$_SESSION['selected_pokemon'] = $playerPokemon;
$_SESSION['opponent'] = $opponents;
$_SESSION['battle_message'] = $message;

header('Location: ../vues/interfaceTournoi.php');
exit;
?>
