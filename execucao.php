<?php

if (PHP_SAPI !== 'cli') {
    exit("Este jogo usa o terminal. Execute: php execucao.php\n");
}

require_once __DIR__ . '/modelo/Jogo/Historia.php';

$historia = new Historia();
$historia->iniciar();