<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\EntityBase;

use Kstrwbry\BinanceTrader\Interface\MACDInterface;
use Kstrwbry\BinanceTrader\Interface\Signal;
use Kstrwbry\BinanceTrader\Interface\SignalPropertyInterface;
use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Kstrwbry\BinanceTrader\Trait\IdTrait;
use Kstrwbry\BinanceTrader\Trait\SignalPropertyTrait;
use Kstrwbry\BinanceTrader\Trait\KlineConnectionTrait;
use Doctrine\ORM\Mapping as ORM;

abstract class MACD implements SignalPropertyInterface, MACDInterface
{
    use
        IdTrait,
        SignalPropertyTrait,
        KlineConnectionTrait
    ;

    public const EVEN            = 0;
    public const SHORT_IS_HIGHER = 1;
    public const LONG_IS_HIGHER  = -1;

    #[ORM\Column(name:'short_period', type:'smallint', nullable:false, options:['default' => 12, 'unsigned' => true])]
    protected readonly int $shortPeriod;
    #[ORM\Column(name:'long_period', type:'smallint', nullable:false, options:['default' => 26, 'unsigned' => true])]
    protected readonly int $longPeriod;
    #[ORM\Column(name:'close', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $close;
    #[ORM\Column(name:'short_ema', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $shortEMA = 0.0;
    #[ORM\Column(name:'long_ema', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $longEMA = 0.0;
    #[ORM\Column(name:'prev_short_ema', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $prevShortEMA = 0.0;
    #[ORM\Column(name:'prev_long_ema', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $prevLongEMA = 0.0;
    #[ORM\Column(name:'cross', type:'signal', nullable:false, options:['default' => 0])]
    protected int $cross = 0;
    #[ORM\Column(name:'prev_cross', type:'signal', nullable:false, options:['default' => 0])]
    protected int $prevCross = 0;

    public function __construct(
        KlineInterface $kline,
        int            $shortPeriod = 12,
        int            $longPeriod = 26,
    ) {
        $this->kline = $kline;
        $this->shortPeriod = $shortPeriod;
        $this->longPeriod = $longPeriod;
        $this->close = $kline->getClose();
    }

    public function getShortPeriod(): int
    {
        return $this->shortPeriod;
    }

    public function getLongPeriod(): int
    {
        return $this->longPeriod;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getShortEMA(): float
    {
        return $this->shortEMA;
    }

    public function setShortEMA(float $shortEMA): static
    {
        $this->shortEMA = $shortEMA;
        return $this;
    }

    public function getLongEMA(): float
    {
        return $this->longEMA;
    }

    public function setLongEMA(float $longEMA): static
    {
        $this->longEMA = $longEMA;
        return $this;
    }

    public function getPrevShortEMA(): float
    {
        return $this->prevShortEMA;
    }

    public function setPrevShortEMA(float $prevShortEMA): static
    {
        $this->prevShortEMA = $prevShortEMA;
        return $this;
    }

    public function getPrevLongEMA(): float
    {
        return $this->prevLongEMA;
    }

    public function setPrevLongEMA(float $prevLongEMA): static
    {
        $this->prevLongEMA = $prevLongEMA;
        return $this;
    }

    public function getCross(): int
    {
        return $this->cross;
    }

    public function getPrevCross(): int
    {
        return $this->prevCross;
    }

    public function calcSignal(): void
    {
        $this->prevCross = $this->prevShortEMA <=> $this->prevLongEMA;
        $this->cross = $this->shortEMA <=> $this->longEMA;

        $signal = Signal::NEUTRAL;

        if($this->cross === static::SHORT_IS_HIGHER && ($this->prevCross === static::EVEN || $this->prevCross === static::LONG_IS_HIGHER)) {
            $signal = Signal::BUY;
        }

        if($this->cross === static::LONG_IS_HIGHER && ($this->prevCross === static::EVEN || $this->prevCross === static::SHORT_IS_HIGHER)) {
            $signal = Signal::SELL;
        }

        $this->setSignal($signal);
    }
}
