<?php

/**
 * AS CINZAS DE PEDRAFORTE
 *
 * Começo: Prólogo + Ato I  (Guilda / Cadastro dos heróis)
 * Meio:   Ato II           (Provas da Arena, Ferreiro e Alquimista)
 * Fim:    Ato III          (Dragão Vermelho Ancestral) + Epílogo (vitória ou derrota)
 */

require_once __DIR__ . '/../Personagens/Personagem.php';
require_once __DIR__ . '/../Personagens/Guerreiro.php';
require_once __DIR__ . '/../Personagens/Mago.php';
require_once __DIR__ . '/../Personagens/Monstro.php';
require_once __DIR__ . '/../Itens/Arma.php';
require_once __DIR__ . '/../Itens/Pocao.php';
require_once __DIR__ . '/../Personagens/Cadastro.php';
require_once __DIR__ . '/Arena.php';

class Historia
{
    private const PROVAS_NECESSARIAS = 3;
    private const DERROTAS_MAXIMAS = 2;

    private Cadastro $cadastro;
    private Arena $arena;
    private int $moedas = 100;
    private bool $armaComprada = false;

    public function __construct()
    {
        $this->cadastro = new Cadastro();
        $this->arena = new Arena($this->cadastro);
    }

    // =====================================================
    //  FLUXO PRINCIPAL
    // =====================================================

    public function iniciar(): void
    {
        $this->prologo();
        $this->ato1Guilda();

        if (!$this->ato2Arena() || !$this->ato3Dragao()) {
            $this->finalDerrota();
            return;
        }

        $this->finalVitoria();
    }

    // =====================================================
    //  COMEÇO
    // =====================================================

    private function prologo(): void
    {
        $this->titulo("AS CINZAS DE PEDRAFORTE");
        $this->narrar(
            "Há três luas, o vulcão de Pedraforte acordou.",
            "Das cavernas descem Goblins famintos. Do velho cemitério, Esqueletos Guerreiros marcham sob um céu vermelho.",
            "Dizem que por trás de tudo está o Dragão Vermelho Ancestral, cujo fogo derrete pedra e esperança.",
            "O Rei abriu as portas da Arena: quem provar seu valor nas Provas de Batalha ganhará o direito de enfrentá-lo."
        );
        $this->pausar();
    }

    private function ato1Guilda(): void
    {
        $this->titulo("ATO I - A GUILDA DOS AVENTUREIROS");
        $this->narrar(
            "No salão da Guilda, o Mestre Balthor ergue os olhos de um mapa manchado de cinzas.",
            "\"Precisamos de heróis: guerreiros de aço e fúria, magos de chama e mana. Registrem seus nomes!\"",
            "(Crie quantos heróis quiser. Se um cair na Arena, os outros continuam a jornada.)"
        );
        $this->pausar();

        do {
            $this->cadastro->cadastrarPersonagens();

            if (empty($this->herois())) {
                $this->narrar("Balthor bate na mesa: \"Sem heróis não há história! Registre alguém!\"");
                $this->pausar();
            }
        } while (empty($this->herois()));

        $this->titulo("ATO I - O JURAMENTO");
        $this->narrar("Balthor confere o livro de registros da Guilda:");
        $this->cadastro->listarJogadores();

        foreach ($this->herois() as $h) {
            if ($h instanceof Guerreiro) {
                $this->narrar("{$h->getNome()} bate o punho no peito. A Espada de Aço da Guilda já está afivelada à sua cintura, e cada golpe alimenta sua fúria.");
            } elseif ($h instanceof Mago) {
                $this->narrar("{$h->getNome()} estende a mão e a Fênix, sua mascote de fogo, pousa em seu ombro, pronta para reforçar cada ataque.");
            }
            $this->fichaHeroi($h);
        }

        $this->narrar(
            "\"Guardem isto\", diz Balthor, entregando uma bolsa com {$this->moedas} moedas.",
            "\"Guerreiros: com 20 de fúria, a Habilidade Especial vira um Golpe Devastador. Magos: 15 de mana valem uma Bola de Fogo.\"",
            "\"Provem seu valor na Arena. Que a sorte dos dados os acompanhe.\""
        );
        $this->pausar();
    }

    // =====================================================
    //  MEIO
    // =====================================================

    private function ato2Arena(): bool
    {
        $this->titulo("ATO II - AS PROVAS DA ARENA");
        $this->narrar(
            "As trombetas soam e a multidão de Pedraforte lota a Arena.",
            "O Rei exige " . self::PROVAS_NECESSARIAS . " vitórias contra as criaturas do vale antes de liberar a marcha até o vulcão.",
            "Mas atenção: " . self::DERROTAS_MAXIMAS . " heróis caídos e a esperança do reino se apaga."
        );
        $this->pausar();

        while ($this->arena->getVitorias() < self::PROVAS_NECESSARIAS) {
            if ($this->arena->getDerrotas() >= self::DERROTAS_MAXIMAS || !$this->temHeroiVivo()) {
                return false;
            }

            $this->limpar();
            echo "\n=== PORTÃO DA ARENA ===\n";
            echo "Provas vencidas: {$this->arena->getVitorias()}/" . self::PROVAS_NECESSARIAS
                . " | Heróis caídos: {$this->arena->getDerrotas()}/" . self::DERROTAS_MAXIMAS
                . " | Moedas: {$this->moedas}\n";
            echo "1. Entrar na Arena\n";
            echo "2. Ferreiro da Guilda\n";
            echo "3. Alquimista\n";
            echo "4. Ver heróis\n";
            echo "Escolha: ";

            switch (trim(fgets(STDIN))) {
                case '1':
                    $this->provaNaArena();
                    break;
                case '2':
                    $this->ferreiro();
                    break;
                case '3':
                    $this->alquimista();
                    break;
                case '4':
                    $this->arena->listarJogadores();
                    foreach ($this->herois() as $h) {
                        $this->fichaHeroi($h);
                    }
                    $this->pausar();
                    break;
                default:
                    echo "\nO arauto inclina a cabeça, sem entender.\n";
                    $this->pausar();
            }
        }

        $this->titulo("ATO II - O PORTÃO DE BASALTO");
        $this->narrar(
            "A terceira prova termina sob aplausos. O Rei desce do camarote em pessoa.",
            "\"Vocês provaram seu valor. Agora, subam o vulcão e acabem com o Dragão Vermelho Ancestral!\""
        );
        $this->pausar();
        return true;
    }

    private function provaNaArena(): void
    {
        $vitoriasAntes = $this->arena->getVitorias();
        $derrotasAntes = $this->arena->getDerrotas();

        $this->arena->escolherPersonagem();

        if ($this->arena->getVitorias() > $vitoriasAntes) {
            $monstro = $this->arena->getUltimoMonstro();
            $xp = $monstro->getExperienciaConcedida();
            $this->moedas += $xp;
            $this->narrar(
                $this->comentarioMonstro($monstro),
                "A plateia ruge! +{$xp} moedas (total: {$this->moedas})."
            );
            $this->pausar();
        } elseif ($this->arena->getDerrotas() > $derrotasAntes) {
            $this->narrar(
                "O herói tomba na areia. Os curandeiros o levam para fora, e seu nome será lembrado no Salão dos Caídos.",
                "Ele não poderá mais lutar."
            );
            $this->pausar();
        }
    }

    private function comentarioMonstro(Monstro $m): string
    {
        $n = $m->getNome();
        $frases = [
            'Terrestre'  => "O rugido rasteiro de {$n} morre na garganta. O povo das cavernas vai pensar duas vezes antes de descer de novo.",
            'Morto-Vivo' => "Os ossos de {$n} se desfazem em pó. Por um instante, o cemitério fica em silêncio.",
            'Fogo'       => "As últimas chamas de {$n} se apagam. Até o vulcão parece hesitar.",
        ];
        return $frases[$m->getTipo()] ?? "{$n} foi derrotado.";
    }

    private function ferreiro(): void
    {
        $this->limpar();
        echo "\n=== FERREIRO DA GUILDA ===\n";

        if ($this->armaComprada) {
            echo "\"Já lhe vendi minha melhor lâmina, guerreiro!\"\n";
            $this->pausar();
            return;
        }

        $arma = new Arma(11, "Lâmina Rúnica de Gelo", 80, 35, "Gelo");
        echo "\"Esta lâmina foi forjada para apagar fogo de dragão.\"\n";
        echo "{$arma->getNome()} - +{$arma->getDanoBono()} de dano, elemento {$arma->getElemento()} - "
            . "{$arma->getValorMoedas()} moedas (você tem {$this->moedas}).\n";

        if ($this->moedas < $arma->getValorMoedas()) {
            echo "\"Volte quando tiver mais moedas.\"\n";
            $this->pausar();
            return;
        }

        echo "Quem vai empunhá-la? (só Guerreiros)\n";
        $guerreiro = $this->escolherHeroi(Guerreiro::class);
        if (!($guerreiro instanceof Guerreiro)) {
            echo "Negócio cancelado.\n";
            $this->pausar();
            return;
        }

        $this->moedas -= $arma->getValorMoedas();
        $this->armaComprada = true;
        $guerreiro->equiparArma($arma);
        $this->pausar();
    }

    private function alquimista(): void
    {
        $this->limpar();
        echo "\n=== ALQUIMISTA ===\n";

        $pocao = new Pocao(1, "Poção de Vida", 20, 25);
        echo "{$pocao->getNome()}: cura {$pocao->getQuantidadeCura()} de vida - "
            . "{$pocao->getValorMoedas()} moedas (você tem {$this->moedas}).\n";

        if ($this->moedas < $pocao->getValorMoedas()) {
            echo "\"Sem moedas, sem poção.\"\n";
            $this->pausar();
            return;
        }

        echo "Quem vai beber?\n";
        $heroi = $this->escolherHeroi();
        if ($heroi === null) {
            echo "Negócio cancelado.\n";
            $this->pausar();
            return;
        }

        if ($heroi->getVida() >= $heroi->getVidaMaxima()) {
            echo "{$heroi->getNome()} já está com a vida cheia.\n";
            $this->pausar();
            return;
        }

        $this->moedas -= $pocao->getValorMoedas();
        $pocao->usar($heroi);
        $this->pausar();
    }

    // =====================================================
    //  FIM
    // =====================================================

    private function ato3Dragao(): bool
    {
        $this->titulo("ATO III - O VULCÃO DE PEDRAFORTE");
        $this->narrar(
            "A trilha até o vulcão é feita de cinzas quentes e silêncio.",
            "No topo, dois olhos incandescentes se abrem na escuridão."
        );

        foreach ($this->heroisVivos() as $h) {
            if ($h instanceof Mago) {
                $this->narrar("A Fênix de {$h->getNome()} solta um canto agudo: é fogo contra fogo, e ela não vai recuar.");
            }
        }

        $this->narrar("Antes da subida, o Rei abençoa cada herói com uma última poção:");
        $bencao = new Pocao(2, "Bênção do Rei", 0, 30);
        foreach ($this->heroisVivos() as $h) {
            $bencao->usar($h);
        }
        $this->pausar();

        $dragao = new Monstro(100, "Dragão Vermelho Ancestral", 150, 18, "Fogo", 500);
        $this->narrar(
            "{$dragao->getNome()} (tipo {$dragao->getTipo()}) desce da cratera, e a terra treme.",
            "Os heróis enfrentam a fera um de cada vez. Se um cair, o próximo assume, e o dragão continua ferido!"
        );
        $this->pausar();

        $vivos = $this->heroisVivos();
        foreach ($vivos as $i => $h) {
            $this->narrar("{$h->getNome()} avança contra o dragão!");

            if ($this->arena->iniciarBatalha($h, $dragao)) {
                $this->moedas += $dragao->getExperienciaConcedida();
                $this->pausar();
                return true;
            }

            $ultimo = ($i === count($vivos) - 1);
            $this->narrar(
                $ultimo
                    ? "{$h->getNome()} tombou e não resta mais ninguém de pé..."
                    : "{$h->getNome()} tombou, mas deixou marcas na fera. O próximo herói toma a frente..."
            );
            $this->pausar();
        }

        return false;
    }

    private function finalVitoria(): void
    {
        $this->titulo("EPÍLOGO - OS CAMPEÕES DA ARENA");
        $this->narrar(
            "O Dragão Vermelho Ancestral desaba e o vulcão exala seu último suspiro de fumaça.",
            "As cavernas ficam quietas, o cemitério em paz, e os sinos de Pedraforte tocam por três dias."
        );

        foreach ($this->heroisVivos() as $h) {
            if ($h instanceof Mago) {
                $this->narrar("Das cinzas do vulcão, a Fênix de {$h->getNome()} renasce ainda mais brilhante e sobrevoa a praça em festa.");
                break;
            }
        }

        echo "\nParabéns por vencerem todas as batalhas, vocês são os campeões da Arena!\n";
        $this->placarFinal();
        echo "\n★ FIM ★\n";
    }

    private function finalDerrota(): void
    {
        $this->titulo("EPÍLOGO - AS CINZAS DA DERROTA");
        $this->narrar(
            "Os portões do vulcão permanecem selados e o céu de Pedraforte continua vermelho.",
            "Balthor apaga uma vela para cada herói caído, mas deixa a última acesa."
        );

        echo "\nInfelizmente vocês foram derrotados na Arena. Mas não desanimem, treinem e voltem mais fortes!\n";
        $this->placarFinal();
        echo "\n☠ FIM DE JOGO ☠\n";
    }

    private function placarFinal(): void
    {
        echo "\n--- PLACAR FINAL ---\n";
        foreach ($this->herois() as $h) {
            echo $h->estaVivo() ? "[Sobrevivente] " : "[Caído] ";
            $this->fichaHeroi($h);
        }
        echo "\nProvas vencidas: {$this->arena->getVitorias()} | Heróis caídos: {$this->arena->getDerrotas()} | Moedas: {$this->moedas}\n";
    }

    // =====================================================
    //  APOIO
    // =====================================================

    private function herois(): array
    {
        return $this->cadastro->getJogadoresCadastrados();
    }

    private function heroisVivos(): array
    {
        return array_values(array_filter($this->herois(), function (Personagem $h) {
            return $h->estaVivo();
        }));
    }

    private function temHeroiVivo(): bool
    {
        return !empty($this->heroisVivos());
    }

    private function fichaHeroi(Personagem $h): void
    {
        echo "#{$h->getId()} {$h->getNome()} - Vida {$h->getVida()}/{$h->getVidaMaxima()} | Ataque {$h->getPontosAtaque()}";
        if ($h instanceof Guerreiro) {
            echo " | Armadura {$h->getArmadura()} | Fúria {$h->getPontosFuria()}";
        } elseif ($h instanceof Mago) {
            echo " | Mana {$h->getMana()} | Poder Mágico {$h->getPoderMagico()}";
        }
        echo "\n";
    }

    private function escolherHeroi(string $classe = Personagem::class): ?Personagem
    {
        $this->arena->listarJogadores();
        echo "Número do herói (0 para cancelar): ";
        $indice = ((int) trim(fgets(STDIN))) - 1;

        $herois = $this->herois();
        if (!isset($herois[$indice])) {
            return null;
        }

        $heroi = $herois[$indice];
        if (!$heroi->estaVivo()) {
            echo "{$heroi->getNome()} não pode mais lutar.\n";
            return null;
        }
        if (!($heroi instanceof $classe)) {
            echo "{$heroi->getNome()} não pode usar isso.\n";
            return null;
        }
        return $heroi;
    }

    private function limpar(): void
    {
        system(PHP_OS_FAMILY === 'Windows' ? 'cls' : 'clear');
    }

    private function pausar(): void
    {
        echo "\nPressione ENTER para continuar...";
        fgets(STDIN);
    }

    private function narrar(string ...$linhas): void
    {
        echo "\n";
        foreach ($linhas as $linha) {
            echo $linha . "\n";
        }
    }

    private function titulo(string $texto): void
    {
        $this->limpar();
        echo "==========================================\n";
        echo "  {$texto}\n";
        echo "==========================================\n";
    }
}