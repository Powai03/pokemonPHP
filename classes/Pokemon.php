<?php

class Pokemon {
    public $name;
    public $type;
    public $health;
    public $attack;
    public $defense;
    public $sprite;
    public $move;
    public $strong;
    public $weak;

    public function __construct($name, $type, $health, $attack, $defense, $sprite, $move, $strong, $weak) {
        $this->name = $name;
        $this->type = $type;
        $this->health = $health;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->sprite = $sprite;
        $this->move = $move;
        $this->strong = $strong;
        $this->weak = $weak;
    }

    public function displayInfo() {
        echo "Name: " . $this->name . "\n";
        echo "Type: " . $this->type . "\n";
        echo "Health: " . $this->health . "\n";
        echo "Attack: " . $this->attack . "\n";
        echo "Defense: " . $this->defense . "\n";
        echo "Sprite: " . $this->sprite . "\n";
        echo "Move: " . $this->move . "\n";
    }

    public static function getAllPokemon() {
        return [
            new Moustillon(),
            new Gruikui(),
            new Vipélierre(),
            new Tiplouf(),
            new Meloetta(),
            new Pikachu(),
            new Gueriaigle(),
            new Tic(),
            new Nanméouïe(),
            new Zorua(),
            new Rototaupe(),
            new Baggiguane(),
        ];
    }
}

class Moustillon extends Pokemon {
    public function __construct() {
        parent::__construct("Moustillon", "Water", 100, 75, 50, "https://img.pokemondb.net/sprites/black-white/anim/normal/oshawott.gif", "Pistolet à 0", "Fire", "Grass");
    }
}

class Gruikui extends Pokemon {
    public function __construct() {
        parent::__construct("Gruikui", "Fire", 70, 55, 40, "https://img.pokemondb.net/sprites/black-white/anim/normal/tepig.gif", "Charge", "Grass", "Water");
    }
}

class Vipélierre extends Pokemon {
    public function __construct() {
        parent::__construct("Vipélierre", "Grass", 65, 50, 45, "https://img.pokemondb.net/sprites/black-white/anim/normal/snivy.gif", "Charge", "Water", "Fire");
    }
}

class Tiplouf extends Pokemon {
    public function __construct() {
        parent::__construct("Tiplouf", "Water", 3, 2, 1, "https://img.pokemondb.net/sprites/black-white/anim/normal/piplup.gif", "Charge", "Fire", "Electric");
    }
}

class Meloetta extends Pokemon {
    public function __construct() {
        parent::__construct("Meloetta", "Psychic", 80, 55, 45, "https://img.pokemondb.net/sprites/black-white/anim/normal/meloetta.gif", "Charge", "Fight", "Dark");
    }
}
class Pikachu extends Pokemon {
    public function __construct() {
        parent::__construct("Pikachu", "Electric", 65, 40, 55, "https://img.pokemondb.net/sprites/black-white/anim/normal/pikachu.gif", "Thunder Shock", "Water", "Ground");
    }
}

class Gueriaigle extends Pokemon {
    public function __construct() {
        parent::__construct("Gueriaigle", "Flying", 75, 45, 45, "https://img.pokemondb.net/sprites/black-white/anim/normal/braviary.gif", "Charge", "Fight", "Electric");
    }
}
class Tic extends Pokemon {
    public function __construct() {
        parent::__construct("Tic", "Steel", 60, 35, 50, "https://img.pokemondb.net/sprites/black-white/anim/normal/klink.gif", "Charge", "Psy", "Fire");
    }
}

class Nanméouïe extends Pokemon {
    public function __construct() {
        parent::__construct("Nanméouïe", "Normal", 100, 10, 60, "https://img.pokemondb.net/sprites/black-white/anim/normal/audino.gif", "Charge", " ", "Fight");
    }
}

class Zorua extends Pokemon {
    public function __construct() {
        parent::__construct("Zorua", "Dark", 60, 60, 30, "https://img.pokemondb.net/sprites/black-white/anim/normal/zorua.gif", "Charge", "Psy", "Fight");
    }
}

class Rototaupe extends Pokemon {
    public function __construct() {
        parent::__construct("Rototaupe", "Ground", 75, 50, 50, "https://img.pokemondb.net/sprites/black-white/anim/normal/drilbur.gif", "Charge", "Electic", "Water");
    }
}

class Baggiguane extends Pokemon {
    public function __construct() {
        parent::__construct("Baggiguane", "Fight", 65, 55, 45, "https://img.pokemondb.net/sprites/black-white/anim/normal/scraggy.gif", "Charge", "Dark", "Flying");
    }
}