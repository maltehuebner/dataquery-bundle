<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\DependencyInjection\Compiler;

use MalteHuebner\DataQueryBundle\Manager\ParameterManagerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ParameterPass implements CompilerPassInterface
{
    #[\Override]
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ParameterManagerInterface::class)) {
            return;
        }

        $parameterManager = $container->findDefinition(ParameterManagerInterface::class);

        $taggedServices = $container->findTaggedServiceIds('data_query.parameter');

        foreach ($taggedServices as $id => $tags) {
            $parameterManager->addMethodCall('addParameter', [new Reference($id)]);
        }
    }
}
