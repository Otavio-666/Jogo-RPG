<?php

require_once 'Personagem.php';

class Guerreiro extends Personagem {
    private int $armadura;
    private int $pontosFuria;
    private ?Arma $armaEquipada = null;

    public function __construct(int $id, string $nome, int $vida, int $pontosAtaque, int $armadura) {
        parent::__construct($id, $nome, $vida, $pontosAtaque);
        $this->armadura = $armadura;
        $this->pontosFuria = 0;
    }

    public function equiparArma(Arma $arma): void {
        $this->armaEquipada = $arma;
        $arma->usar($this);
    }

    public function atacar(Personagem $alvo): void {
        $danoTotal = $this->pontosAtaque + ($this->armaEquipada ? $this->armaEquipada->getDanoBono() : 0);
        $this->pontosFuria += 10;
        echo "🗡️ Guerreiro {$this->nome} ataca com a espada! (Fúria: {$this->pontosFuria})\n";
        $alvo->receberDano($danoTotal);
    }

    public function golpeDevastador(Personagem $alvo): void {
        if ($this->pontosFuria >= 20) {
            $dano = ($this->pontosAtaque * 2);
            $this->pontosFuria -= 20;
            echo "🔥 GOLPE DEVASTADOR! {$this->nome} usou 20 de fúria!\n";
            $alvo->receberDano($dano);
        } else {
            echo "⚠️ Fúria insuficiente! Realizando ataque normal...\n";
            $this->atacar($alvo);
        }
    }
}