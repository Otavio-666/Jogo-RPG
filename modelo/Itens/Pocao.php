<?php

require_once 'Item.php';

class Pocao extends Item {
    private int $quantidadeCura;

    public function __construct(int $id, string $nome, int $valorMoedas, int $quantidadeCura) {
        parent::__construct($id, $nome, $valorMoedas);
        $this->quantidadeCura = $quantidadeCura;
    }
    

    public function usar(Personagem $p): void {
        echo "🧪 {$p->getNome()} usou {$this->nome} e recuperou {$this->quantidadeCura} de vida!\n";
        $p->curar($this->quantidadeCura);
    }
}