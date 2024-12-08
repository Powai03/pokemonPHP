
<?php

session_start();

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/fin.css">
</head>
<body>
    <div class="resume">
    <?php
if($_SESSION['game_mode'] === 'Exhibition'){


if ($_SESSION['issue'] === "win") {
    echo "<h1>Félicitations, vous avez gagné !</h1>";
    echo "<h2>".$_SESSION['nbAttaque'] . " attaques effectuées</h2>";
    echo "<h2>Dégâts infligés : " . $_SESSION['degats']."</h2>";
    echo "<h2>Dégâts subis : " . $_SESSION['degatsAdversaire']."</h2>";
} else {
    echo "<h1>Dommage, vous avez perdu...</h1>";
    echo "<h2>".$_SESSION['nbAttaque'] . " attaques effectuées</h2>";
    echo "<h2>Dégâts infligés : " . $_SESSION['degats']."</h2>";
    echo "<h2>Dégâts subis : " . $_SESSION['degatsAdversaire']."</h2>";
}
} else {
    echo "<h1>Tournoi terminé !</h1>";
    echo "<h2>Dégâts infligés : " . $_SESSION['degats']."</h2>";
    echo "<h2>Dégâts subis : " . $_SESSION['degatsAdversaire']."</h2>";
    echo "<h2>Nombre d'adversaires vaincus : " . $_SESSION['nbAdversaireVaincu']."</h2>";
}
?>

    <a href="index.php">Revenir à l'accueil</a>
    </div>
</body>
</html>