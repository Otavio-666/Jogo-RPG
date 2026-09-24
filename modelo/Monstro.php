<?php

require_once __DIR__ . '/Personagem.php';

class Monstro extends Personagem {
    private string $tipo;
    private int $experienciaConcedida;

    public function __construct(int $id, string $nome, int $vida, int $pontosAtaque, string $tipo, int $exp) {
        parent::__construct($id, $nome, $vida, $pontosAtaque);
        $this->tipo = $tipo;
        $this->experienciaConcedida = $exp;
    }

    public function getTipo(): string { return $this->tipo; }
    public function getExperienciaConcedida(): int { return $this->experienciaConcedida; }

    public function atacar(Personagem $alvo): void {
        echo " Monstro {$this->nome} ({$this->tipo}) atacou selvagemente!\n";
        $alvo->receberDano($this->pontosAtaque);
    }
}