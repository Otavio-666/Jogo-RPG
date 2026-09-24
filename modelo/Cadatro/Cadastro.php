<?php

require_once 'modelo/Jogador/Guerreiro.php';
require_once 'modelo/Jogador/Mago.php';
require_once 'modelo/Gerenciador/Arena.php';
require_once 'modelo/Jogador/Personagem.php';

class Cadastro {

    private array $jogadoresCadastrados = [];

    public function cadastrarJogador(Personagem $p): void {
        $this->jogadoresCadastrados[] = $p;
        echo "\n✅ Personagem {$p->getNome()} cadastrado com sucesso!\n";
    }

    public function listarJogadores(): void {
        echo "\n--- JOGADORES CADASTRADOS ---\n";
        if (empty($this->jogadoresCadastrados)) {
            echo "Nenhum jogador cadastrado.\n";
            return;
        }
        foreach ($this->jogadoresCadastrados as $i => $j) {
            echo "[" . ($i + 1) . "] {$j->getNome()} - Vida: {$j->getVida()} - Classe: " . get_class($j) . "\n";
        }
    }

    public function cadastrarPersonagens(): void {
        while (true) {
                echo "\n======================================\n";
                echo "               Modo Batalha            \n";
                echo "======================================\n";
                echo "1. Criar Guerreiro\n";
                echo "2. Criar Mago\n";
                echo "3. Listar Personagens\n";
                echo "0. Sair\n";
                echo "Escolha uma opção: ";

                $opcao = trim(fgets(STDIN));

                switch ($opcao) {
                    case '1':
                        echo "Nome do Guerreiro: ";
                        $nome = trim(fgets(STDIN));
                        $g = new Guerreiro(rand(1, 99), $nome, rand(1, 100), 12, 5);
                        $espada = new Arma(10, "Espada de Aço", 50, rand(1, 50), "Físico");
                        $g->equiparArma($espada);
                        $this->cadastrarJogador($g);
                        break;

                    case '2':
                        echo "Nome do Mago: ";
                        $nome = trim(fgets(STDIN));
                        $m = new Mago(rand(1, 99), $nome, rand(1, 100), 8, 40, 15);
                        $this->cadastrarJogador($m);
                        break;

                    case '3':
                        $this->listarJogadores();
                        break;

                    case '0':
                        echo "Retornado a Historia\n";
                        return;

                    default:
                        echo "Opção inválida!\n";
                }
        }
    }   

    public function getJogadoresCadastrados(): array {
        return $this->jogadoresCadastrados;
    }

}