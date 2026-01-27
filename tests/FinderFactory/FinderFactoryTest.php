<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FinderFactory;

use Doctrine\ORM\EntityManagerInterface;
use MalteHuebner\DataQueryBundle\Finder\Finder;
use MalteHuebner\DataQueryBundle\Finder\FinderInterface;
use MalteHuebner\DataQueryBundle\FinderFactory\FinderFactory;
use MalteHuebner\DataQueryBundle\FinderFactory\FinderFactoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;

class FinderFactoryTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $locator = $this->createMock(ServiceLocator::class);
        $factory = new FinderFactory($locator);

        $this->assertInstanceOf(FinderFactoryInterface::class, $factory);
    }

    public function testCreateFinderWithDoctrineEntityManager(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $locator = $this->createMock(ServiceLocator::class);
        $locator->method('has')
            ->willReturnCallback(function (string $id) {
                return $id === EntityManagerInterface::class;
            });
        $locator->method('get')
            ->willReturnCallback(function (string $id) use ($entityManager) {
                if ($id === EntityManagerInterface::class) {
                    return $entityManager;
                }
                return null;
            });

        $factory = new FinderFactory($locator);
        $finder = $factory->createFinderForFqcn('App\\Entity\\SimpleTestEntity');

        $this->assertInstanceOf(FinderInterface::class, $finder);
    }

    public function testCreateFinderThrowsWhenNeitherAvailable(): void
    {
        $locator = $this->createMock(ServiceLocator::class);
        $locator->method('has')->willReturn(false);

        $factory = new FinderFactory($locator);

        $this->expectException(\RuntimeException::class);

        $factory->createFinderForFqcn('App\\Entity\\TestEntity');
    }
}
