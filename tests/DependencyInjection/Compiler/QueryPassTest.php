<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\DependencyInjection\Compiler;

use MalteHuebner\DataQueryBundle\DependencyInjection\Compiler\QueryPass;
use MalteHuebner\DataQueryBundle\Manager\QueryManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class QueryPassTest extends TestCase
{
    public function testProcessAddsMethodCallsForTaggedServices(): void
    {
        $container = new ContainerBuilder();
        $container->register(QueryManagerInterface::class, QueryManagerInterface::class);
        $container->register('query1', 'App\\Query\\TestQuery')
            ->addTag('data_query.query');
        $container->register('query2', 'App\\Query\\TestQuery2')
            ->addTag('data_query.query');

        $pass = new QueryPass();
        $pass->process($container);

        $definition = $container->findDefinition(QueryManagerInterface::class);
        $methodCalls = $definition->getMethodCalls();

        $this->assertCount(2, $methodCalls);
        $this->assertSame('addQuery', $methodCalls[0][0]);
        $this->assertSame('addQuery', $methodCalls[1][0]);
    }

    public function testProcessDoesNothingWhenManagerNotRegistered(): void
    {
        $container = new ContainerBuilder();
        $container->register('query1', 'App\\Query\\TestQuery')
            ->addTag('data_query.query');

        $pass = new QueryPass();

        // Should not throw
        $pass->process($container);

        $this->assertFalse($container->has(QueryManagerInterface::class));
    }

    public function testProcessWithNoTaggedServices(): void
    {
        $container = new ContainerBuilder();
        $container->register(QueryManagerInterface::class, QueryManagerInterface::class);

        $pass = new QueryPass();
        $pass->process($container);

        $definition = $container->findDefinition(QueryManagerInterface::class);
        $methodCalls = $definition->getMethodCalls();

        $this->assertCount(0, $methodCalls);
    }
}
