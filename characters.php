<?php

class Character
{
    private $name;
    private $marbles;

    public function __construct($name, $marbles)
    {
        $this->name = $name;
        $this->marbles = $marbles;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMarbles()
    {
        return $this->marbles;
    }

    public function setMarbles($value)
    {
        $this->marbles = $value;
    }
}

final class Hero extends Character
{
    private $loss;
    private $gain;
    private $screamWar;

    public function __construct($name, $marbles, $loss, $gain, $screamWar)
    {
        parent::__construct($name, $marbles);
        $this->loss = $loss;
        $this->gain = $gain;
        $this->screamWar = $screamWar;
    }

    public function getLoss()
    {
        return $this->loss;
    }

    public function getGain()
    {
        return $this->gain;
    }

    public function getScreamWar()
    {
        return $this->screamWar;
    }

    private static function randomChoice()
    {
        return Utils::generateRandomNumber(0, 1);
    }

    public function checkChoice($enemyMarbles)
    {
        $randomChoice = self::randomChoice();
        return ($randomChoice == 0 && $enemyMarbles % 2 == 0) ||
            ($randomChoice == 1 && $enemyMarbles % 2 != 0);
    }
}

final class Enemy extends Character
{
    private $age;

    public function __construct($name, $marbles, $age)
    {
        parent::__construct($name, $marbles);
        $this->age = $age;
    }

    public function getAge()
    {
        return $this->age;
    }
}