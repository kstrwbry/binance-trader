<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Indicator;

use Kstrwbry\BinanceTrader\Interface\RVIInterface;
use Doctrine\Common\Collections\ArrayCollection;

/** Relative volatility index (RVI) */
class RVI
{
    private readonly int $period;

    #private array $rvi = [];
    private array $stdDev = [];

    private array $upperEMA = [];
    private array $lowerEMA = [];

    private float $upperSum = 0;
    private float $lowerSum = 0;

    public function __construct(
        private readonly ArrayCollection $numbers,
    ) {
        $this->period = $this->numbers->first()->getPeriod();
        $this->calc();
    }

    public function add(RVIInterface $number): void
    {
        $this->numbers->add($number);
        $index = $this->numbers->indexOf($number);
        $this->calcRVI($index, $number);
    }

    private function calc(): void
    {
        foreach($this->numbers as $index => $number) {
            $this->calcRVI($index, $number);
        }
    }

    private function calcRVI(int $index, RVIInterface $number): void
    {
        $value = $number->getStdDev();
        $this->stdDev[] = $value;
        $prevValue = $this->stdDev[$index-1] ?? 0.0;

        $upperEMA = $value > $prevValue ? $value : 0.0;
        $lowerEMA = $value < $prevValue ? $value : 0.0;
        $this->upperEMA[] = $upperEMA;
        $this->lowerEMA[] = $lowerEMA;
        $number->setUpperEMA($upperEMA);
        $number->setLowerEMA($lowerEMA);

        if($index >= $this->period) {
            $this->upperSum -= array_shift($this->upperEMA);
            $this->lowerSum -= array_shift($this->lowerEMA);
        }
        $this->upperSum += $upperEMA;
        $this->lowerSum += $lowerEMA;
        $number->setUpperEMASum($this->upperSum);
        $number->setLowerEMASum($this->lowerSum);

        if($this->upperSum === 0.0) $this->upperSum = 0.001;
        if($this->lowerSum === 0.0) $this->lowerSum = 0.001;

        $rvi = 100 * ($this->upperSum / ($this->upperSum + $this->lowerSum));
        #$this->rvi[] = $rvi;
        $number->setRvi($rvi);
    }
}
