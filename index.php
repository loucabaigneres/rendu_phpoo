<?php

require_once 'utils.php';
require_once 'characters.php';
require_once 'game.php';

// Lancement du jeu
$game = new Game();
$game->startGame();