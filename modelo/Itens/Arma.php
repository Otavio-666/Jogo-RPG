<?php

require_once 'Item.php';

class Arma extends Item {
    private int $danoBono;
    private string $elemento;

    public function __construct(int $id, string $nome, int $valorMoedas, int $danoBono, string $elemento) {
        parent::__construct($id, $nome, $valorMoedas);
        $this->danoBono = $danoBono;
        $this->elemento = $elemento;
    }

    public function getDanoBono(): int {
        return $this->danoBono;
    }

    public function usar(Personagem $p): void {
        echo "{$p->getNome()} equipou a arma {$this->nome} (+{$this->danoBono} dano)!\n";
    }
}