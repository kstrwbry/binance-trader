<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface KlineRawInterface
{
    public function getClose(): float;

    public function isClosed(): bool;
}
