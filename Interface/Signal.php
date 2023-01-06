<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface Signal
{
    public const BUY     = 1;
    public const SELL    = -1;
    public const NEUTRAL = 0;
}
