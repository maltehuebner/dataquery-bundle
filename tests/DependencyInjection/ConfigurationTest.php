<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\DependencyInjection;

use MalteHuebner\DataQueryBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $configuration = new Configuration();

        $this->assertInstanceOf(ConfigurationInterface::class, $configuration);
    }

    public function testGetConfigTreeBuilder(): void
    {
        $configuration = new Configuration();
        $treeBuilder = $configuration->getConfigTreeBuilder();

        $this->assertNotNull($treeBuilder);
        $this->assertSame('malte_huebner_data_query', $treeBuilder->buildTree()->getName());
    }
}
