<?php

declare(strict_types=1);

namespace Quinggu\OrderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('order');
        $treeBuilder->getRootNode()
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }
}
