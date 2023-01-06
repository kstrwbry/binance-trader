<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Trait;

use Kstrwbry\BinanceTrader\Interface\KlineInterface;
use Doctrine\ORM\Mapping as ORM;

trait KlineConnectionTrait #implements KlineConnectionInterface
{
    #[ORM\OneToOne(inversedBy: 'id', targetEntity: KlineInterface::class, cascade: ['persist'])]
    protected readonly KlineInterface $kline;

    public function getKline(): KlineInterface
    {
        return $this->kline;
    }

    public function getClose(): float
    {
        return $this->kline->getClose();
    }
}
