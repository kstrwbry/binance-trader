<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Helpers;

use function array_slice;
use function array_sum;
use function count;

/** Simple moving average (SMA) */
class SMA
{
    public static function calc(array $numbers, int $n): array
    {
        $m   = count($numbers);
        $SMA = [];

        $new       = $n;
        $drop      = 0;
        $yesterday = 0;

        $SMA[] = array_sum(array_slice($numbers, 0, $n)) / $n;

        while ($new < $m) {
            $SMA[] = $SMA[$yesterday] + ($numbers[$new] / $n) - ($numbers[$drop] / $n);
            $drop++;
            $yesterday++;
            $new++;
        }

        return $SMA;
    }
}
