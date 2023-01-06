<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\EntityBase;

use Kstrwbry\BinanceTrader\Interface\StdDevInterface;
use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Kstrwbry\BinanceTrader\Trait\IdTrait;
use Kstrwbry\BinanceTrader\Trait\KlineConnectionTrait;
use Doctrine\ORM\Mapping as ORM;

abstract class StdDev implements StdDevInterface
{
    use
        IdTrait,
        KlineConnectionTrait
    ;

    #[ORM\Column(name:'period', type:'smallint', nullable:false, options:['default' => 14, 'unsigned' => true])]
    protected readonly int $period;
    #[ORM\Column(name:'close', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $close;

    #[ORM\Column(name:'avg', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $avg = 0.0;
    #[ORM\Column(name:'sum', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $sum = 0.0;
    #[ORM\Column(name:'std_dev', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $stdDev = 0.0;

    public function __construct(
        KlineInterface $kline,
        int            $period = 14
    ) {
        $this->kline  = $kline;
        $this->period = $period;
        $this->close  = $kline->getClose();
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    public function getAvg(): float
    {
        return $this->avg;
    }

    public function setAvg(float $avg): static
    {
        $this->avg = $avg;
        return $this;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): static
    {
        $this->sum = $sum;
        return $this;
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
}
