<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests;

use MalteHuebner\DataQueryBundle\MalteHuebnerDataQueryBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MalteHuebnerDataQueryBundleTest extends TestCase
{
    public function testExtendsBundle(): void
    {
        $bundle = new MalteHuebnerDataQueryBundle();

        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function testBuildRegistersCompilerPasses(): void
    {
        $container = new ContainerBuilder();
        $bundle = new MalteHuebnerDataQueryBundle();

        $passCountBefore = count($container->getCompilerPassConfig()->getBeforeOptimizationPasses());

        $bundle->build($container);

        $passCountAfter = count($container->getCompilerPassConfig()->getBeforeOptimizationPasses());

        $this->assertGreaterThan($passCountBefore, $passCountAfter);
    }

    public function testBuildRegistersAutoconfiguration(): void
    {
        $container = new ContainerBuilder();
        $bundle = new MalteHuebnerDataQueryBundle();

        $bundle->build($container);

        $autoconfigured = $container->getAutoconfiguredInstanceof();

        $this->assertArrayHasKey(\MalteHuebner\DataQueryBundle\Query\QueryInterface::class, $autoconfigured);
        $this->assertArrayHasKey(\MalteHuebner\DataQueryBundle\Parameter\ParameterInterface::class, $autoconfigured);
    }

    public function testQueryInterfaceAutoConfigurationHasCorrectTag(): void
    {
        $container = new ContainerBuilder();
        $bundle = new MalteHuebnerDataQueryBundle();
        $bundle->build($container);

        $autoconfigured = $container->getAutoconfiguredInstanceof();
        $queryDefinition = $autoconfigured[\MalteHuebner\DataQueryBundle\Query\QueryInterface::class];

        $this->assertTrue($queryDefinition->hasTag('data_query.query'));
    }

    public function testParameterInterfaceAutoConfigurationHasCorrectTag(): void
    {
        $container = new ContainerBuilder();
        $bundle = new MalteHuebnerDataQueryBundle();
        $bundle->build($container);

        $autoconfigured = $container->getAutoconfiguredInstanceof();
        $parameterDefinition = $autoconfigured[\MalteHuebner\DataQueryBundle\Parameter\ParameterInterface::class];

        $this->assertTrue($parameterDefinition->hasTag('data_query.parameter'));
    }
}
