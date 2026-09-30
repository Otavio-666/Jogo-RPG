<?php

require_once __DIR__ . '/Guerreiro.php';
require_once __DIR__ . '/Mago.php';
require_once __DIR__ . '/Personagem.php';
require_once __DIR__ . '/../Itens/Arma.php';

class Cadastro {

    private array $jogadoresCadastrados = [];

    
    private function limparTela(): void {
        system(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');
    }

    
    private function pausar(): void {
        echo "\nPressione ENTER para continuar...";
        fgets(STDIN);
    }

    public function cadastrarJogador(Personagem $p): void {
        $this->jogadoresCadastrados[] = $p;
        echo "\n Personagem {$p->getNome()} cadastrado com sucesso!\n";
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
                $this->limparTela();
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
                        $this->pausar();
                        break;

                    case '2':
                        echo "Nome do Mago: ";
                        $nome = trim(fgets(STDIN));
                        $m = new Mago(rand(1, 99), $nome, rand(1, 100), 8, 40, 15);
                        $this->cadastrarJogador($m);
                        $this->pausar();
                        break;

                    case '3':
                        $this->listarJogadores();
                        $this->pausar();
                        break;

                    case '0':
                        echo "Retornado a Historia\n";
                        sleep(1);
                        $this->limparTela();
                        return;

                    default:
                        echo "Opção inválida!\n";
                        $this->pausar();
                }
        }
    }

    public function getJogadoresCadastrados(): array {
        return $this->jogadoresCadastrados;
    }

}