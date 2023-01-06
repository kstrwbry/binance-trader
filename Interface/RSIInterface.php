<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface RSIInterface extends KlineConnectionInterface
{
    public function __construct(
        KlineInterface $kline,
        int $period = 14
    );

    public function calcRSI(): void;

    public function setGainSum(float $gainSum): static;

    public function setLossSum(float $lossSum): static;

    public function getPeriod(): int;

    public function getGainSum(): float;

    public function getLossSum(): float;

    public function getAvgGain(): float;

    public function getAvgLoss(): float;

    public function getRs(): float;

    public function getRsi(): float;
}
