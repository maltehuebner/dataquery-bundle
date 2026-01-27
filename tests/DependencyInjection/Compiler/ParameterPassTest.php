<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\DependencyInjection\Compiler;

use MalteHuebner\DataQueryBundle\DependencyInjection\Compiler\ParameterPass;
use MalteHuebner\DataQueryBundle\Manager\ParameterManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ParameterPassTest extends TestCase
{
    public function testProcessAddsMethodCallsForTaggedServices(): void
    {
        $container = new ContainerBuilder();
        $container->register(ParameterManagerInterface::class, ParameterManagerInterface::class);
        $container->register('parameter1', 'App\\Parameter\\TestParameter')
            ->addTag('data_query.parameter');
        $container->register('parameter2', 'App\\Parameter\\TestParameter2')
            ->addTag('data_query.parameter');

        $pass = new ParameterPass();
        $pass->process($container);

        $definition = $container->findDefinition(ParameterManagerInterface::class);
        $methodCalls = $definition->getMethodCalls();

        $this->assertCount(2, $methodCalls);
        $this->assertSame('addParameter', $methodCalls[0][0]);
        $this->assertSame('addParameter', $methodCalls[1][0]);
    }

    public function testProcessDoesNothingWhenManagerNotRegistered(): void
    {
        $container = new ContainerBuilder();
        $container->register('parameter1', 'App\\Parameter\\TestParameter')
            ->addTag('data_query.parameter');

        $pass = new ParameterPass();

        // Should not throw
        $pass->process($container);

        $this->assertFalse($container->has(ParameterManagerInterface::class));
    }

    public function testProcessWithNoTaggedServices(): void
    {
        $container = new ContainerBuilder();
        $container->register(ParameterManagerInterface::class, ParameterManagerInterface::class);

        $pass = new ParameterPass();
        $pass->process($container);

        $definition = $container->findDefinition(ParameterManagerInterface::class);
        $methodCalls = $definition->getMethodCalls();

        $this->assertCount(0, $methodCalls);
    }
}
