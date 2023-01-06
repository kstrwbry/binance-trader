<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Indicator;

use Kstrwbry\BinanceTrader\Interface\RSIInterface;
use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Doctrine\Common\Collections\ArrayCollection;

class RSI
{
    public function __construct(
        private readonly ArrayCollection $numbers
    ) {
        $this->calc();
    }

    public function add(RSIInterface $number): void
    {
        $this->numbers->add($number);
        $index = $this->numbers->indexOf($number);
        $this->calcRSI($index, $number);
    }

    private function calc(): void
    {
        foreach($this->numbers as $index => $number) {
            $this->calcRSI($index, $number);
        }
    }

    private function calcRSI(int $index, RSIInterface $number): void
    {
        $kline = $number->getKline();
        /** @var RSIInterface $prev */
        $prev = $this->numbers->get($index-1);

        $outdatedIndex = $index-$number->getPeriod();

        /** @var KlineInterface|null $outdatedKline */
        $outdatedKline = $this->numbers->get($outdatedIndex)?->getKline();

        $outdatedGain = $outdatedKline ? $outdatedKline->getGain() : 0.0;
        $outdatedLoss = $outdatedKline ? $outdatedKline->getLoss() : 0.0;

        $prevGainSum = $prev ? $prev->getGainSum() : 0.0;
        $prevLossSum = $prev ? $prev->getLossSum() : 0.0;

        $number->setGainSum($prevGainSum - $outdatedGain + $kline->getGain());
        $number->setLossSum($prevLossSum - $outdatedLoss + $kline->getLoss());

        $number->calcRSI();
    }
}
