<?php

require_once __DIR__ . '/../Personagens/Personagem.php';
require_once __DIR__ . '/../Personagens/Guerreiro.php';
require_once __DIR__ . '/../Personagens/Mago.php';
require_once __DIR__ . '/../Personagens/Monstro.php';
require_once __DIR__ . '/../Itens/Item.php';
require_once __DIR__ . '/../Itens/Arma.php';
require_once __DIR__ . '/../Itens/Pocao.php';
require_once __DIR__ . '/../Personagens/Cadastro.php';

class Arena
{

    private Cadastro $cadastro;

    private int $vitorias = 0;
    private int $derrotas = 0;
    private ?Monstro $ultimoMonstro = null;

    public function __construct(Cadastro $cadastro)
    {
        $this->cadastro = $cadastro;
    }

    public function getVitorias(): int { return $this->vitorias; }
    public function getDerrotas(): int { return $this->derrotas; }
    public function getUltimoMonstro(): ?Monstro { return $this->ultimoMonstro; }

    public function listarJogadores(): void
    {
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

    public function gerarMonstroAleatorio(): Monstro
    {
        $monstros = [
            new Monstro(101, "Goblin da Caverna", 40, 8, "Terrestre", 50),
            new Monstro(102, "Dragão Vermelho", 80, 15, "Fogo", 200),
            new Monstro(103, "Esqueleto Guerreiro", 50, 10, "Morto-Vivo", 80)
        ];
        return $monstros[array_rand($monstros)];
    }

    public function iniciarBatalha(Personagem $jogador, ?Monstro $monstro = null): bool
    {
        $monstro = $monstro ?? $this->gerarMonstroAleatorio();
        $this->ultimoMonstro = $monstro;

        echo "\n==========================================\n";
        echo " BATALHA INICIADA: {$jogador->getNome()} VS {$monstro->getNome()}\n";
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
            echo "\nVITÓRIA! {$jogador->getNome()} derrotou o {$monstro->getNome()}!\n";
            $this->vitorias++;
            return true;
        }

        echo "\nDERROTA! {$jogador->getNome()} foi derrotado...\n";
        $this->derrotas++;
        return false;
    }

    public function escolherPersonagem(): void
    {
        while (true) {
            echo "\n======================================\n";
            echo "               Modo Batalha            \n";
            echo "======================================\n";
            echo "1. Escolher Personagem\n";
            echo "0. Voltar\n";
            echo "Escolha uma opção: ";

            $opcao = trim(fgets(STDIN));

            switch ($opcao) {
                case '1':
                    $jogadores = $this->cadastro->getJogadoresCadastrados();
                    if (empty($jogadores)) {
                        echo "\nCrie um personagem antes de ir para a batalha!\n";
                        break;
                    }
                    $this->listarJogadores();
                    echo "Escolha o número do personagem para batalhar: ";
                    $index = ((int)trim(fgets(STDIN))) - 1;

                    if (!isset($jogadores[$index])) {
                        echo "Opção inválida! Selecione um personagem válido.\n";
                        break;
                    }

                    if ($jogadores[$index]->estaVivo()) {
                        $this->iniciarBatalha($jogadores[$index]);
                        return; 
                    } else {
                        echo "Personagem esta sem vida!\nSelecione outro.\n";
                    }
                    break;

                case '0':
                    return;

                default:
                    echo "Opção inválida!\n";
            }
        }
    }

}