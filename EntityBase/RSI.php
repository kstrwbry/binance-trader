<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\EntityBase;

use Kstrwbry\BinanceTrader\Interface\RSIInterface;
use Kstrwbry\BinanceTrader\Interface\SignalPropertyInterface;
use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Kstrwbry\BinanceTrader\Trait\IdTrait;
use Kstrwbry\BinanceTrader\Trait\SignalPropertyTrait;
use Kstrwbry\BinanceTrader\Trait\KlineConnectionTrait;
use Doctrine\ORM\Mapping as ORM;

abstract class RSI implements SignalPropertyInterface, RSIInterface
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
    #[ORM\Column(name:'gain', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $gain;
    #[ORM\Column(name:'loss', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected readonly float $loss;

    #[ORM\Column(name:'gain_sum', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $gainSum = 0.0;
    #[ORM\Column(name:'loss_sum', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $lossSum = 0.0;
    #[ORM\Column(name:'avg_gain', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $avgGain = 0.0;
    #[ORM\Column(name:'avg_loss', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $avgLoss = 0.0;

    #[ORM\Column(name:'rs', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $rs = 0.0;
    #[ORM\Column(name:'rsi', type:'float', nullable:false, options:['default' => 0, 'unsigned' => true])]
    protected float $rsi = 0.0;

    public function __construct(
        KlineInterface $kline,
        int            $period = 14
    ) {
        $this->kline  = $kline;
        $this->period = $period;
        $this->close  = $kline->getClose();
        $this->gain   = $kline->getGain();
        $this->loss   = $kline->getLoss();
    }

    public function calcRSI(): void
    {
        $this->avgGain = $this->calcAvg($this->gainSum, $this->period);
        $this->avgLoss = $this->calcAvg($this->lossSum, $this->period);

        if($this->avgGain === 0.0) {
            $this->rs  = 0;
            $this->rsi = 100;
            return;
        }

        if($this->avgLoss === 0.0) {
            $this->rs  = INF;
            $this->rsi = 0;
            return;
        }

        $this->rs  = $this->avgGain / $this->avgLoss;
        $this->rsi = 100.0 - (100.0 / (1.0 + $this->rs));
    }

    private function calcAvg(
        float $sum,
        int $period
    ): float {
        if(0.0 <= $sum || 0.0 <= $period) {
            return 0.0;
        }

        return $sum / $period;
    }

    public function setGainSum(float $gainSum): static
    {
        $this->gainSum = $gainSum;
        return $this;
    }

    public function setLossSum(float $lossSum): static
    {
        $this->lossSum = $lossSum;
        return $this;
    }

    public function getPeriod(): int
    {
        return $this->period;
    }

    public function getGainSum(): float
    {
        return $this->gainSum;
    }

    public function getLossSum(): float
    {
        return $this->lossSum;
    }

    public function getAvgGain(): float
    {
        return $this->avgGain;
    }

    public function getAvgLoss(): float
    {
        return $this->avgLoss;
    }

    public function getRs(): float
    {
        return $this->rs;
    }

    public function getRsi(): float
    {
        return $this->rsi;
    }

    public function getClose(): float
    {
        return $this->close;
    }
}





