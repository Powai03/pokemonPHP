<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/index.css">
</head>
<body>
    <h1>Bienvenue dans le monde de Pokémon!</h1>
    <h2>Prêt à relever ce défi?</h2>
    <p>Choisissez le mode de jeu et commencez votre aventure!</p>
    <div class="container">
            <div class="vert">
                <form action="choixPokemon.php" method="post">
                    <input type="hidden" name="mode" value="Exhibition">
                    <button type="submit" class="btn">Exhibition</button>
                </form>
            </div>
            <div class="rouge">
                <form action="choixPokemon.php" method="post">
                    <input type="hidden" name="mode" value="Tournoi">
                    <button type="submit" class="btn">Tournoi</button>
                </form>
            </div>
        
    </div>
</body>
</html>