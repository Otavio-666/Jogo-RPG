<?php

require_once 'modelo/Mascote.php';
require_once 'modelo/Cadastro.php';        
require_once 'modelo/Arma.php';
require_once 'modelo/Personagem.php';
require_once 'modelo/Guerreiro.php';
require_once 'modelo/Mago.php';
require_once 'modelo/Arena.php';

function pausa(): void {
    echo "\n(Pressione ENTER para continuar...)";
    fgets(STDIN);
}

// ==========================================
// A ARENA DOS HERÓIS
// ==========================================

echo "==========================================\n";
echo "            A ARENA DOS HERÓIS           \n";
echo "==========================================\n\n";

echo "No reino digital de Cadastria, tudo começava sempre da mesma forma:\n";
echo "um pergaminho de boas-vindas surgia diante de qualquer aventureiro\n";
echo "que ousasse entrar no Salão do Cadastro.\n";
pausa();

echo "\n\"Criar Guerreiro. Criar Mago. Listar Personagens. Sair.\"\n";
echo "— recitou a Guardiã do Registro, uma entidade silenciosa que anotava\n";
echo "cada nome em seus livros infinitos.\n";
pausa();

echo "\nFoi assim que nasceram Thalgor, o Guerreiro, e Elysia, a Maga.\n";
pausa();

echo "\nThalgor surgiu já com a armadura reluzente e os olhos acesos por uma\n";
echo "fúria antiga. Mal tocou o chão da Arena, empunhou sua Espada de Aço,\n";
echo "presente de um velho ferreiro que jurava tê-la forjado com cinquenta\n";
echo "moedas de sua própria poupança.\n";
echo "\"Com isso na mão, nenhum monstro vai me fazer recuar\" — disse ele,\n";
echo "testando o peso da lâmina.\n";
pausa();

echo "\nElysia, por sua vez, chegou envolta em um manto azul-noite, cercada\n";
echo "por um brilho quente. Ao seu lado pairava Fênix, seu mascote de fogo,\n";
echo "sempre pronta para somar sua chama ao feitiço da maga.\n";
echo "\"Você e eu, Fênix. Como sempre\" — sussurrou Elysia, coçando a\n";
echo "cabecinha da ave mágica.\n";
pausa();

echo "\nRegistrados os dois, a Guardiã do Registro os conduziu à Arena, o\n";
echo "verdadeiro coração de Cadastria, onde o Gerenciador supremo decidia\n";
echo "os destinos das batalhas.\n";
echo "\"Escolham seu campeão\" — anunciou o Gerenciador. \"A Arena sorteará\n";
echo "um adversário à altura.\"\n\n";

echo "==========================================\n";
echo "        A JORNADA COMEÇA AGORA...         \n";
echo "==========================================\n";
pausa();

// ==========================================
// CRIAÇÃO DOS HERÓIS DA HISTÓRIA
// ==========================================

$cadastro = new Cadastro();

$thalgor = new Guerreiro(1, "Thalgor", 100, 15, 8);
$espadaDeAco = new Arma(10, "Espada de Aço", 50, 20, "Físico");
$thalgor->equiparArma($espadaDeAco);
$cadastro->cadastrarJogador($thalgor);

$elysia = new Mago(2, "Elysia", 80, 8, 40, 20);
$cadastro->cadastrarJogador($elysia);

echo "\nThalgor e Elysia já estão prontos e cadastrados na Arena!\n";
pausa();

// ==========================================
// INÍCIO DO JOGO
// ==========================================

$arena = new Arena($cadastro);
$arena->escolherPersonagem();
