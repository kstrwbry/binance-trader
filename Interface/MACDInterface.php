<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface MACDInterface
{
    public function getShortPeriod(): int;

    public function getLongPeriod(): int;

    public function getClose(): float;

    public function getShortEMA(): float;

    public function setShortEMA(float $shortEMA): static;

    public function getLongEMA(): float;

    public function setLongEMA(float $longEMA): static;

    public function getPrevShortEMA(): float;

    public function setPrevShortEMA(float $prevShortEMA): static;

    public function getPrevLongEMA(): float;

    public function setPrevLongEMA(float $prevLongEMA): static;

    public function getCross(): int;

    public function getPrevCross(): int;

    public function calcSignal(): void;
}
