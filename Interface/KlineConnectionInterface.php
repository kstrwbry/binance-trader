<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface KlineConnectionInterface
{
    #public function __construct(KlineInterface $kline);

    public function getKline(): KlineInterface;

    #public function setKline(KlineInterface $kline): static;

    public function getClose(): float;
}
