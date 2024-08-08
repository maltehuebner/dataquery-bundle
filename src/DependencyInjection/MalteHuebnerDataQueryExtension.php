<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\Extension;

class MalteHuebnerDataQueryExtension extends Extension
{
    #[\Override]
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration(false);
        $config = $this->processConfiguration($configuration, $configs);

        $xmlLoader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $xmlLoader->load('services.xml');
    }
}
