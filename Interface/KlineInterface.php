<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface KlineInterface
{
    public function setPrev(KlineInterface $prev): static;

    public function getPrev(): KlineInterface|null;

    public function getClose(): float;

    public function getPrevClose(): float;

    public function getDiff(): float;

    public function getGain(): float;

    public function getLoss(): float;
}
