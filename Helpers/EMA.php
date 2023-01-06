<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Helpers;

use function count;

/** Exponential moving average (EMA) */
class EMA
{
    public static function calc(array $numbers, int $period): array
    {
        $m   = count($numbers);
        $a   = 2 / ($period + 1);
        $EMA = [];

        $EMA[] = $numbers[0];

        for ($i = 1; $i < $m; $i++) {
            $EMA[] = ($a * $numbers[$i]) + ((1 - $a) * $EMA[$i - 1]);
        }

        return $EMA;
    }
}
