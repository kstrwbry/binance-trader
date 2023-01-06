<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader\Trait;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id', type:'bigint', nullable:false, options:['unsigned' => true])]
    protected ?int $id = null;
}
