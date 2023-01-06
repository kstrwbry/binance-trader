<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\EntityBase;

use Kstrwbry\BinanceTrader\Interface\RVIInterface;
use Kstrwbry\BinanceTrader\Interface\SignalPropertyInterface;
use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Kstrwbry\BinanceTrader\Trait\IdTrait;
use Kstrwbry\BinanceTrader\Trait\SignalPropertyTrait;
use Kstrwbry\BinanceTrader\Trait\KlineConnectionTrait;
use Doctrine\ORM\Mapping as ORM;

abstract class RVI implements SignalPropertyInterface, RVIInterface
{
    use
        IdTrait,
        SignalPropertyTrait,
        KlineConnectionTrait
    ;

    #[ORM\Column(name:'period', type:'smallint', nullable:false, options:['default' => 14, 'unsigned' => true])]
    protected readonly int $period;
    #[ORM\Column(name:'close', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $close;
    #[ORM\Column(name:'upper_signal', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $upperSignalLine;
    #[ORM\Column(name:'lower_signal', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $lowerSignalLine;
    #[ORM\Column(name:'std_dev', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $stdDev = 0.0;
    #[ORM\Column(name:'upper_ema', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $upperEMA = 0.0;
    #[ORM\Column(name:'lower_ema', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $lowerEMA = 0.0;
    #[ORM\Column(name:'upper_ema_sum', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $upperEMASum = 0.0;
    #[ORM\Column(name:'lower_ema_sum', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $lowerEMASum = 0.0;
    #[ORM\Column(name:'rvi', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $rvi = 0.0;

    public function __construct(
        KlineInterface $kline,
        int            $period = 14,
        float          $lowerSignalLine = 30,
        float          $upperSignalLine = 70,
        float          $stdDev = 0,
    ) {
        $this->kline  = $kline;
        $this->period = $period;
        $this->stdDev = $stdDev;
        $this->close  = $kline->getClose();
        $this->lowerSignalLine = $lowerSignalLine;
        $this->upperSignalLine = $upperSignalLine;
    }
    
    public function getPeriod(): int
    {
        return $this->period;
    }
    
    public function getClose(): float
    {
        return $this->close;
    }
    
    public function getUpperSignalLine(): float
    {
        return $this->upperSignalLine;
    }
    
    public function getLowerSignalLine(): float
    {
        return $this->lowerSignalLine;
    }
    
    public function getStdDev(): float
    {
        return $this->stdDev;
    }
    
    public function setStdDev(float $stdDev): static
    {
        $this->stdDev = $stdDev;
        return $this;
    }
    
    public function getUpperEMASum(): float
    {
        return $this->upperEMASum;
    }
    
    public function setUpperEMASum(float $upperEMASum): static
    {
        $this->upperEMASum = $upperEMASum;
        return $this;
    }
    
    public function getLowerEMASum(): float
    {
        return $this->lowerEMASum;
    }
    
    public function setLowerEMASum(float $lowerEMASum): static
    {
        $this->lowerEMASum = $lowerEMASum;
        return $this;
    }
    
    public function getRvi(): float
    {
        return $this->rvi;
    }
    
    public function setRvi(float $rvi): static
    {
        $this->rvi = $rvi;
        return $this;
    }

    public function getUpperEMA(): float
    {
        return $this->upperEMA;
    }

    public function setUpperEMA(float $upperEMA): static
    {
        $this->upperEMA = $upperEMA;
        return $this;
    }

    public function getLowerEMA(): float
    {
        return $this->lowerEMA;
    }

    public function setLowerEMA(float $lowerEMA): static
    {
        $this->lowerEMA = $lowerEMA;
        return $this;
    }
}
