<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Helpers;

/** Cumulative moving average (CMA) */
class CMA
{
    public static function calc(array $numbers): array
    {
        $m   = \count($numbers);
        $CMA = [];

        $CMA[] = $numbers[0];

        for ($i = 1; $i < $m; $i++) {
            $CMA[] = (($numbers[$i]) + ($CMA[$i - 1] * $i)) / ($i + 1);
        }

        return $CMA;
    }
}
