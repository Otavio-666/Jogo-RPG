<?php

require_once __DIR__ . '/Personagem.php';

abstract class Item {
    protected int $id;
    protected string $nome;
    protected int $valorMoedas;

    public function __construct(int $id, string $nome, int $valorMoedas) {
        $this->id = $id;
        $this->nome = $nome;
        $this->valorMoedas = $valorMoedas;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getValorMoedas(): int {
        return $this->valorMoedas;
    }

    abstract public function usar(Personagem $p): void;
}