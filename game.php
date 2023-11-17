<?php

class Game
{

    private $difficultyLevels = [
        'Facile' => 5,
        'Difficile' => 10,
        'Impossible' => 20
    ];
    private $heroes;
    private $enemies;

    public function __construct()
    {
        $this->createHeroes();
        $this->createEnemies();
    }

    private function createHeroes()
    {
        $seongGiHun = new Hero("Seong Gi-Hun", 15, 2, 1, "Yaouh!");
        $kangSaeByeok = new Hero("Kang Sae-byeok", 25, 1, 2, "Yeahhhh!");
        $choSangWoo = new Hero("Cho Sang-woo", 35, 0, 3, "Let's go!");

        $this->heroes = [$seongGiHun, $kangSaeByeok, $choSangWoo];
    }

    private function createEnemies()
    {
        for ($i = 1; $i < 20; $i++) {
            $enemy = new Enemy("Enemy $i", Utils::generateRandomNumber(1, 20), Utils::generateRandomNumber(70, 80));
            $this->enemies[] = $enemy;
        }
    }

    public function randomHero()
    {
        return $this->heroes[array_rand($this->heroes)];
    }

    public function randomEnemy()
    {
        return $this->enemies[array_rand($this->enemies)];
    }

    public function randomDifficulty()
    {
        return array_rand($this->difficultyLevels);
    }

    public function startGame()
    {
        $selectedHero = $this->randomHero();
        $selectedDifficulty = $this->randomDifficulty();
        $gameLenght = $this->difficultyLevels[$selectedDifficulty];

        echo "Héros sélectionné : " . $selectedHero->getName();
        echo "<br>";
        echo "Difficulté sélectionnée : $selectedDifficulty";
        echo "<br>";
        echo "Nombre de manches : " . $gameLenght;
        echo "<br>";

        $this->playGame($selectedHero, $gameLenght);
        $this->endGame($selectedHero);
    }

    private function playGame($selectedHero, $gameLenght)
    {
        $i = 1;
        while ($i <= $gameLenght && $selectedHero->getMarbles() > 0 && !empty($this->enemies)) {
            $currentEnemy = $this->randomEnemy();
            echo "<br>";
            echo "Manche $i.";
            echo "<br>";
            echo "Billes restantes : " . $selectedHero->getMarbles();
            echo "<br>";
            echo "Vous affrontez " . $currentEnemy->getName() . ". Ce dernier a " . $currentEnemy->getAge() . " ans.";

            if ($currentEnemy->getAge() > 70) {
                $choiceToCheat = rand(0, 1) == 0;

                if ($choiceToCheat) {
                    $this->cheatGame($selectedHero, $currentEnemy);
                } else {
                    echo "<br>";
                    echo "Vous décidez de rester loyal et d'affronter votre ennemi normalement.";
                    $this->classicGame($selectedHero, $currentEnemy);
                }
            } else {
                $this->classicGame($selectedHero, $currentEnemy);
            }
            $i++;
        }
    }

    private function classicGame($selectedHero, $currentEnemy)
    {
        if ($selectedHero->checkChoice($currentEnemy->getMarbles())) {
            echo "<br>";
            $selectedHero->setMarbles($selectedHero->getMarbles() + $currentEnemy->getMarbles() + $selectedHero->getGain());
            echo "Vous avez gagné ! Vous avez maintenant " . $selectedHero->getMarbles() . " billes.";
            echo "<br>";
            echo $currentEnemy->getName() . " avait " . $currentEnemy->getMarbles() . " billes.";
            echo "<br>";
            array_splice($this->enemies, array_search($currentEnemy, $this->enemies), 1);
        } else {
            echo "<br>";
            $selectedHero->setMarbles($selectedHero->getMarbles() - $currentEnemy->getMarbles() - $selectedHero->getLoss());
            echo $currentEnemy->getName() . " avait " . $currentEnemy->getMarbles() . " billes.";
            echo "<br>";
            echo "Vous avez perdu ! Il vous reste " . $selectedHero->getMarbles() . " billes.";
            echo "<br>";
        }
    }

    private function cheatGame($selectedHero, $currentEnemy)
    {
        echo "<br>";
        echo "Vous choisissez de tricher en profitant de la vieillesse de votre adversaire.";
        echo "<br>";
        $selectedHero->setMarbles($selectedHero->getMarbles() + $currentEnemy->getMarbles());
        echo "Vous récupérez alors les " . $currentEnemy->getMarbles() . " billes de votre adversaire.";
        echo "<br>";
        echo "Vous avez maintenant " . $selectedHero->getMarbles() . " billes.";
        echo "<br>";
        array_splice($this->enemies, array_search($currentEnemy, $this->enemies), 1);
    }

    private function endGame($selectedHero)
    {
        if ($selectedHero->getMarbles() > 0) {
            echo "<br>";
            echo "La victoire revient à " . $selectedHero->getName() . ", qui est parvenu à terminer toutes les manches en gardant " . $selectedHero->getMarbles() . " billes. Il remporte donc la modique somme de ₩45 600 000 000 !";
            echo "<br>";
            echo "Vous vous écriez alors : " . $selectedHero->getScreamWar();
        } else {
            echo "<br>";
            echo "C'est fini pour vous. Game Over!";
        }
    }
}