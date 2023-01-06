<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface StdDevInterface extends KlineConnectionInterface
{
    public function __construct(
        KlineInterface $kline,
        int $period = 14
    );

    public function getPeriod(): int;

    public function getAvg(): float;
    public function setAvg(float $avg): static;

    public function getSum(): float;
    public function setSum(float $sum): static;

    public function setStdDev(float $stdDev): static;
    public function getStdDev(): float;
}
