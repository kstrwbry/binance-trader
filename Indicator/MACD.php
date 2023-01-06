<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Indicator;

use Kstrwbry\BinanceTrader\Helpers\EMA;
use Kstrwbry\BinanceTrader\Interface\MACDInterface;
use Doctrine\Common\Collections\ArrayCollection;

class MACD
{
    private readonly int $shortPeriod;
    private readonly int $longPeriod;
    private array $closingPrice = [];

    private array $shortEMA = [];
    private array $longEMA = [];

    public function __construct(
        private readonly ArrayCollection $numbers
    ) {
        /** @var MACDInterface $number */
        $number = $this->numbers->first();
        $this->shortPeriod = $number->getShortPeriod();
        $this->longPeriod  = $number->getLongPeriod();

        $this->calc();
    }

    public function add(MACDInterface $number): void
    {
        $this->numbers->add($number);
        $index = $this->numbers->indexOf($number);
        $this->calcEMA();
        $this->calcMACD($index, $number);
    }

    private function calc(): void
    {
        $this->calcEMA();
        foreach($this->numbers as $index => $number) {
            $this->calcMACD($index, $number);
        }
    }

    private function calcEMA(): void
    {
        $this->shortEMA = EMA::calc($this->closingPrice, $this->shortPeriod);
        $this->longEMA  = EMA::calc($this->closingPrice, $this->longPeriod);
    }

    private function calcMACD(int $index, MACDInterface $number): void
    {
        $prevShort = $this->shortEMA[$index-1] ?? 0.0;
        $prevLong  = $this->longEMA[$index-1]  ?? 0.0;

        $number
            ->setPrevShortEMA($prevShort)
            ->setPrevLongEMA($prevLong)
            ->setShortEMA($this->shortEMA[$index])
            ->setLongEMA($this->longEMA[$index])
        ;

        $number->calcSignal();
    }
}
