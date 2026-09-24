<?php

require_once 'modelo/Cadatro/Cadastro.php';
require_once 'modelo/Gerenciador/Arena.php';

// Inicialização da Aplicação
// 1. Cria a instância de Cadastro
$cadastro = new Cadastro();

// 2. Cadastra os personagens
$cadastro->cadastrarPersonagens();

// 3. Passa a instância de Cadastro para a Arena
$arena = new Arena($cadastro);
$arena->escolherPersonagem();