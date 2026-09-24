<?php

abstract class Personagem {
    protected int $id;
    protected string $nome;
    protected int $vida;
    protected int $vidaMaxima;
    protected int $pontosAtaque;

    public function __construct(int $id, string $nome, int $vida, int $pontosAtaque) {
        $this->id = $id;
        $this->nome = $nome;
        $this->vida = $vida;
        $this->vidaMaxima = $vida;
        $this->pontosAtaque = $pontosAtaque;
    }

    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getVida(): int { return $this->vida; }
    public function getVidaMaxima(): int { return $this->vidaMaxima; }
    public function getPontosAtaque(): int { return $this->pontosAtaque; }
    public function estaVivo(): bool { return $this->vida > 0; }

    public function receberDano(int $dano): void {
        $this->vida -= $dano;
        if ($this->vida < 0) $this->vida = 0;
        echo " {$this->nome} recebeu {$dano} de dano! (Vida atual: {$this->vida}/{$this->vidaMaxima})\n";
    }

    public function curar(int $qtd): void {
        $this->vida += $qtd;
        if ($this->vida > $this->vidaMaxima) $this->vida = $this->vidaMaxima;
        echo " {$this->nome} foi curado em {$qtd} pontos de vida. Vida atual: {$this->vida}/{$this->vidaMaxima}\n";
    }

    abstract public function atacar(Personagem $alvo): void;
}