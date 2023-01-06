<?php
declare(strict_types=1);

namespace Kstrwbry\BinanceTrader;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class BinanceTraderBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('Resources/config/doctrine.yaml');
    }

    public function getNamespace(): string
    {
        return 'Kstrwbry\BinanceTrader';
    }
}
