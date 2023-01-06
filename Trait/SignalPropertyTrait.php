<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Trait;

use Doctrine\ORM\Mapping as ORM;

trait SignalPropertyTrait #implements SignalInterface
{
    #[ORM\Column(name:'signal', type:'signal', nullable:false, options:['default' => 0])]
    protected int $signal = 0;

    public function getSignal(): int
    {
        return $this->signal <=> 0;
    }

    public function setSignal(int $signal): static
    {
        $this->signal = $signal <=> 0;
        return $this;
    }
}
