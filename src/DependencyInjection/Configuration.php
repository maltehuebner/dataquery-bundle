<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    #[\Override]
    public function getConfigTreeBuilder(): TreeBuilder
    {
        // Alias des Bundles (siehe getAlias() in deiner Extension!)
        $treeBuilder = new TreeBuilder('malte_huebner_data_query');

        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
