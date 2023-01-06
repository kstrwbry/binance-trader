<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\EntityBase;

use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Kstrwbry\BinanceTrader\Interface\KlineRawInterface;
use Kstrwbry\BinanceTrader\Trait\IdTrait;
use Doctrine\ORM\Mapping as ORM;

abstract class Kline implements KlineInterface
{
    use IdTrait;

    #[ORM\OneToOne(inversedBy: 'id', targetEntity: KlineRawInterface::class, cascade: ['persist'])]
    protected KlineRawInterface|null $raw = null;

    #[ORM\OneToOne(inversedBy: 'id', targetEntity: KlineInterface::class, cascade: ['persist'])]
    protected KlineInterface|null $prev = null;

    #[ORM\Column(name:'close', type:'float', nullable:false, options:['unsigned' => true])]
    protected readonly float $close;

    #[ORM\Column(name:'prev_close', type:'float', nullable:false, options:['unsigned' => true])]
    protected float $prevClose = 0.0;

    #[ORM\Column(name:'diff', type:'float', nullable:false, options:['default' => 0])]
    protected float $diff = 0.0;

    #[ORM\Column(name:'gain', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $gain = 0.0;

    #[ORM\Column(name:'loss', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $loss = 0.0;

    public function __construct(
        KlineRaw   $raw,
        Kline|null $prev
    ) {
        $this->raw  = $raw;
        $this->prev = $prev;

        $this->close = $raw->getClose();

        if($prev) {
            $this->setPrev($prev);
        }
    }

    private function calcDiff(): void
    {
        $diff = $this->prev
            ? $this->close - $this->prev->getClose()
            : 0.0
        ;

        $this->diff = $diff;
        $this->gain = $diff > 0.0 ? abs($diff) : 0.0;
        $this->loss = $diff < 0.0 ? abs($diff) : 0.0;
    }

    public function getDiff(): float
    {
        return $this->diff;
    }

    public function getGain(): float
    {
        return $this->gain;
    }

    public function getLoss(): float
    {
        return $this->loss;
    }

    public function setPrev(KlineInterface $prev): static
    {
        $this->prev = $prev;
        $this->prevClose = $prev->getClose();
        $this->calcDiff();
        return $this;
    }

    public function getPrev(): KlineInterface|null
    {
        return $this->prev;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getPrevClose(): float
    {
        return $this->prevClose;
    }
}
