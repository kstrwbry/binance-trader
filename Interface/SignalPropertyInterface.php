<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Interface;

interface SignalPropertyInterface
{
    /**
     * @return Signal::BUY|Signal::SELL|Signal::NEUTRAL
     */
    public function getSignal(): int;

    /**
     * @param Signal::BUY|Signal::SELL|Signal::NEUTRAL $signal
     */
    public function setSignal(int $signal): static;
}
