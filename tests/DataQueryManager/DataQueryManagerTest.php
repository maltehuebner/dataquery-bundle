<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\DataQueryManager;

use MalteHuebner\DataQueryBundle\DataQueryManager\DataQueryManager;
use MalteHuebner\DataQueryBundle\DataQueryManager\DataQueryManagerInterface;
use MalteHuebner\DataQueryBundle\Factory\ParameterFactory\ParameterFactoryInterface;
use MalteHuebner\DataQueryBundle\Factory\QueryFactory\QueryFactoryInterface;
use MalteHuebner\DataQueryBundle\Finder\FinderInterface;
use MalteHuebner\DataQueryBundle\FinderFactory\FinderFactoryInterface;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;

class DataQueryManagerTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $queryFactory = $this->createMock(QueryFactoryInterface::class);
        $parameterFactory = $this->createMock(ParameterFactoryInterface::class);
        $finderFactory = $this->createMock(FinderFactoryInterface::class);

        $manager = new DataQueryManager($queryFactory, $parameterFactory, $finderFactory);

        $this->assertInstanceOf(DataQueryManagerInterface::class, $manager);
    }

    public function testQueryCallsFactoriesAndFinder(): void
    {
        $requestParameterList = new RequestParameterList();
        $entityFqcn = 'App\\Entity\\Ride';

        $queryList = ['q1' => new \stdClass()];
        $parameterList = [new \stdClass()];
        $expectedResults = ['result1', 'result2'];

        $queryFactory = $this->createMock(QueryFactoryInterface::class);
        $queryFactory->expects($this->once())
            ->method('setEntityFqcn')
            ->with($entityFqcn)
            ->willReturnSelf();
        $queryFactory->expects($this->once())
            ->method('createFromList')
            ->with($requestParameterList)
            ->willReturn($queryList);

        $parameterFactory = $this->createMock(ParameterFactoryInterface::class);
        $parameterFactory->expects($this->once())
            ->method('setEntityFqcn')
            ->with($entityFqcn)
            ->willReturnSelf();
        $parameterFactory->expects($this->once())
            ->method('createFromList')
            ->with($requestParameterList)
            ->willReturn($parameterList);

        $finder = $this->createMock(FinderInterface::class);
        $finder->expects($this->once())
            ->method('executeQuery')
            ->with($queryList, $parameterList)
            ->willReturn($expectedResults);

        $finderFactory = $this->createMock(FinderFactoryInterface::class);
        $finderFactory->expects($this->once())
            ->method('createFinderForFqcn')
            ->with($entityFqcn)
            ->willReturn($finder);

        $manager = new DataQueryManager($queryFactory, $parameterFactory, $finderFactory);

        $result = $manager->query($requestParameterList, $entityFqcn);

        $this->assertSame($expectedResults, $result);
    }

    public function testQueryReturnsEmptyArrayWhenNoResults(): void
    {
        $queryFactory = $this->createMock(QueryFactoryInterface::class);
        $queryFactory->method('setEntityFqcn')->willReturnSelf();
        $queryFactory->method('createFromList')->willReturn([]);

        $parameterFactory = $this->createMock(ParameterFactoryInterface::class);
        $parameterFactory->method('setEntityFqcn')->willReturnSelf();
        $parameterFactory->method('createFromList')->willReturn([]);

        $finder = $this->createMock(FinderInterface::class);
        $finder->method('executeQuery')->willReturn([]);

        $finderFactory = $this->createMock(FinderFactoryInterface::class);
        $finderFactory->method('createFinderForFqcn')->willReturn($finder);

        $manager = new DataQueryManager($queryFactory, $parameterFactory, $finderFactory);

        $result = $manager->query(new RequestParameterList(), 'App\\Entity\\Ride');

        $this->assertSame([], $result);
    }

    public function testQueryPassesEntityFqcnToAllFactories(): void
    {
        $entityFqcn = 'App\\Entity\\MyEntity';

        $queryFactory = $this->createMock(QueryFactoryInterface::class);
        $queryFactory->expects($this->once())
            ->method('setEntityFqcn')
            ->with($entityFqcn)
            ->willReturnSelf();
        $queryFactory->method('createFromList')->willReturn([]);

        $parameterFactory = $this->createMock(ParameterFactoryInterface::class);
        $parameterFactory->expects($this->once())
            ->method('setEntityFqcn')
            ->with($entityFqcn)
            ->willReturnSelf();
        $parameterFactory->method('createFromList')->willReturn([]);

        $finderFactory = $this->createMock(FinderFactoryInterface::class);
        $finder = $this->createMock(FinderInterface::class);
        $finder->method('executeQuery')->willReturn([]);
        $finderFactory->expects($this->once())
            ->method('createFinderForFqcn')
            ->with($entityFqcn)
            ->willReturn($finder);

        $manager = new DataQueryManager($queryFactory, $parameterFactory, $finderFactory);
        $manager->query(new RequestParameterList(), $entityFqcn);
    }
}
