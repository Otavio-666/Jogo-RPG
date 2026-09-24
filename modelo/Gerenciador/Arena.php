<?php

require_once 'modelo/Jogador/Personagem.php';
require_once 'modelo/Jogador/Guerreiro.php';
require_once 'modelo/Jogador/Mago.php';
require_once 'modelo/Jogador/Monstro.php';
require_once 'modelo/Itens/Item.php';
require_once 'modelo/Itens/Arma.php';
require_once 'modelo/Itens/Pocao.php';
require_once 'modelo/Cadatro/Cadastro.php';

class Arena  {

    private Cadastro $cadastro;

    public function __construct(Cadastro $cadastro) {
        $this->cadastro = $cadastro;
    }

    public function listarJogadores(): void {
        echo "\n--- JOGADORES CADASTRADOS ---\n";
        $jogadores = $this->cadastro->getJogadoresCadastrados();
        if (empty($jogadores)) {
            echo "Nenhum jogador cadastrado.\n";
            return;
        }
        foreach ($jogadores as $i => $j) {
            echo "[" . ($i + 1) . "] {$j->getNome()} - Vida: {$j->getVida()} - Classe: " . get_class($j) . "\n";
        }
    }

    public function gerarMonstroAleatorio(): Monstro {
        $monstros = [
            new Monstro(101, "Goblin da Caverna", 40, 8, "Terrestre", 50),
            new Monstro(102, "Dragão Vermelho", 80, 15, "Fogo", 200),
            new Monstro(103, "Esqueleto Guerreiro", 50, 10, "Morto-Vivo", 80)
        ];
        return $monstros[array_rand($monstros)];
    }

    public function iniciarBatalha(Personagem $jogador): void {
        $monstro = $this->gerarMonstroAleatorio();
        echo "\n==========================================\n";
        echo "⚔️ BATALHA INICIADA: {$jogador->getNome()} VS {$monstro->getNome()}\n";
        echo "==========================================\n";

        $pocaoCura = new Pocao(1, "Poção de Vida", 20, 25);

        while ($jogador->estaVivo() && $monstro->estaVivo()) {
            echo "\n--- SEU TURNO --- (Sua Vida: {$jogador->getVida()} | Vida Inimigo: {$monstro->getVida()})\n";
            echo "1. Ataque Normal\n";
            echo "2. Habilidade Especial\n";
            echo "3. Usar Poção de Cura\n";
            echo "Escolha sua ação: ";
            $opcao = trim(fgets(STDIN));

            switch ($opcao) {
                case '1':
                    $jogador->atacar($monstro);
                    break;
                case '2':
                    if ($jogador instanceof Guerreiro) {
                        $jogador->golpeDevastador($monstro);
                    } elseif ($jogador instanceof Mago) {
                        $jogador->lancarBolaDeFogo($monstro);
                    }
                    break;
                case '3':
                    $pocaoCura->usar($jogador);
                    break;
                default:
                    echo "Opção inválida! Perdeu o turno.\n";
            }

            if ($monstro->estaVivo()) {
                echo "\n--- TURNO DO INIMIGO ---\n";
                $monstro->atacar($jogador);
            }
        }

        if ($jogador->estaVivo()) {
            echo "\n🎉 VITÓRIA! {$jogador->getNome()} derrotou o {$monstro->getNome()}!\n";
        } else {
            echo "\n☠️ DERROTA! {$jogador->getNome()} foi derrotado...\n";
        }
    }

    public function escolherPersonagem(): void {
        while (true) {
            echo "\n======================================\n";
            echo "               Modo Batalha            \n";
            echo "======================================\n";
            echo "1. Escolher Personagem\n";
            echo "Escolha uma opção: ";

            $opcao = trim(fgets(STDIN));

            switch ($opcao) {
                case '1':
                    $jogadores = $this->cadastro->getJogadoresCadastrados();
                    if (empty($jogadores)) {
                        echo "\n⚠️ Crie um personagem antes de ir para a batalha!\n";
                        break;
                    }
                    $this->listarJogadores();
                    echo "Escolha o número do personagem para batalhar: ";
                    $index = ((int)trim(fgets(STDIN))) - 1;

                    if (isset($jogadores[$index])) {
                        $this->iniciarBatalha($jogadores[$index]);
                    } else {
                        echo "Personagem inválido!\n";
                    }
                    break;

                default:
                    echo "Opção inválida!\n";
            }
        }
    }
}