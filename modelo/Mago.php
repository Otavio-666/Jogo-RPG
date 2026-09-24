<?php

require_once __DIR__ . '/Personagem.php';
require_once __DIR__ . '/Mascote.php';

class Mago extends Personagem {
    private int $mana;
    private int $poderMagico;
    private ?Mascote $mascote = null;

    public function __construct(int $id, string $nome, int $vida, int $pontosAtaque, int $mana, int $poderMagico) {
        parent::__construct($id, $nome, $vida, $pontosAtaque);
        $this->mana = $mana;
        $this->poderMagico = $poderMagico;
        $this->mascote = new Mascote("Fênix", "Fogo", 10);
    }

    public function getMana(): int { return $this->mana; }
    public function getPoderMagico(): int { return $this->poderMagico; }

    public function atacar(Personagem $alvo): void {
        $danoTotal = $this->pontosAtaque;
        if ($this->mascote) {
            $danoTotal += $this->mascote->ajudarAtaque();
        }
        echo " Mago {$this->nome} lança um projétil místico!\n";
        $alvo->receberDano($danoTotal);
    }

    public function lancarBolaDeFogo(Personagem $alvo): void {
        if ($this->mana >= 15) {
            $this->mana -= 15;
            $dano = $this->poderMagico * 2;
            echo " BOLA DE FOGO! {$this->nome} gastou 15 de Mana! (Mana restante: {$this->mana})\n";
            $alvo->receberDano($dano);
        } else {
            echo " Mana insuficiente! Realizando ataque normal...\n";
            $this->atacar($alvo);
        }
    }
}