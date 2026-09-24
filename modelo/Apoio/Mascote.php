<?php

class Mascote {
    private string $nome;
    private string $elemento;
    private int $danoSuporte;

    public function __construct(string $nome, string $elemento, int $danoSuporte) {
        $this->nome = $nome;
        $this->elemento = $elemento;
        $this->danoSuporte = $danoSuporte;
    }

    public function ajudarAtaque(): int {
        echo "🐾 Mascote {$this->nome} ataca com poder de {$this->elemento}!\n";
        return $this->danoSuporte;
    }
}