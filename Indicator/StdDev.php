<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Indicator;

use Kstrwbry\BinanceTrader\Interface\StdDevInterface;
use Doctrine\Common\Collections\ArrayCollection;

use function end;
use function min;
use function sqrt;

/** Standard deviation (StdDev) */
class StdDev
{
    private readonly int $period;
    private array $closingPrice = [];
    private array $closingPriceSum = [];

    public function __construct(
        private readonly ArrayCollection $numbers
    ) {
        $this->period = $this->numbers->first()->getPeriod();
        $this->calc();
    }

    public function add(StdDevInterface $number): void
    {
        $this->numbers->add($number);
        $index = $this->numbers->indexOf($number);
        $this->calcStdDev($index, $number);
    }

    private function calc(): void
    {
        foreach($this->numbers as $index => $number) {
            $this->calcStdDev($index, $number);
        }
    }

    public function calcStdDev(int $index, StdDevInterface $number): void
    {
        $close = $number->getClose();
        $this->closingPrice[] = $close;

        $priceSum = end($this->closingPriceSum);
        $outDatedPrice = $this->closingPrice[$this->period - $index] ?? 0;
        $priceSum = $priceSum + $close - $outDatedPrice;

        $number->setSum($priceSum);
        $this->closingPriceSum[] = $priceSum;

        if(0 === $index) {
            $number->setAvg($close);
            return;
        }

        $period = min($index+1, $this->period);
        $avg = $priceSum / $period;
        $number->setAvg($avg);

        $stdDevSum = 0;
        for($i = 0; $i < $period; $i++) {
            $stdDevSum += ($this->closingPrice[$index - $i] - $avg) ** 2;
        }

        $stdDevValue = sqrt($stdDevSum / $period);

        $number->setStdDev($stdDevValue);
    }
}
