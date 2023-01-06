<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface RVIInterface extends KlineConnectionInterface
{
    public function __construct(
        KlineInterface $kline,
        int             $period = 14,
        float           $lowerSignalLine = 30,
        float           $upperSignalLine = 70,
        float           $stdDev = 0,
    );

    public function getPeriod(): int;

    public function getUpperSignalLine(): float;

    public function getLowerSignalLine(): float;

    public function getStdDev(): float;
    public function setStdDev(float $stdDev): static;

    public function getUpperEMASum(): float;
    public function setUpperEMASum(float $upperEMASum): static;

    public function getLowerEMASum(): float;
    public function setLowerEMASum(float $lowerEMASum): static;

    public function getRvi(): float;
    public function setRvi(float $rvi): static;

    public function getUpperEMA(): float;
    public function setUpperEMA(float $upperEMA): static;

    public function getLowerEMA(): float;
    public function setLowerEMA(float $lowerEMA): static;
}
