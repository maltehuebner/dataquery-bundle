<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Finder;

use Doctrine\ORM\EntityManagerInterface;
use MalteHuebner\DataQueryBundle\Finder\Finder;
use MalteHuebner\DataQueryBundle\Finder\FinderInterface;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use PHPUnit\Framework\TestCase;

class FinderTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $finder = new Finder('App\\Entity\\Ride');

        $this->assertInstanceOf(FinderInterface::class, $finder);
    }

    public function testExecuteQueryReturnsEmptyArrayWhenNeitherEngineAvailable(): void
    {
        $finder = new Finder('App\\Entity\\Ride', null, null);

        $result = $finder->executeQuery([], []);

        $this->assertSame([], $result);
    }

    public function testExecuteOrmQueryWithEmptyLists(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $queryBuilder = $this->createMock(\Doctrine\ORM\QueryBuilder::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->willReturnSelf();
        $queryBuilder->method('setMaxResults')->willReturnSelf();

        $ormQuery = $this->createMock(\Doctrine\ORM\Query::class);
        $ormQuery->method('getResult')->willReturn([]);
        $queryBuilder->method('getQuery')->willReturn($ormQuery);

        $entityManager->method('createQueryBuilder')->willReturn($queryBuilder);

        $finder = new Finder('App\\Entity\\Ride', null, $entityManager);

        $result = $finder->executeQuery([], []);

        $this->assertSame([], $result);
    }

    public function testExecuteOrmQuerySetsDefaultMaxResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $queryBuilder = $this->createMock(\Doctrine\ORM\QueryBuilder::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('setMaxResults')
            ->with(10)
            ->willReturnSelf();

        $ormQuery = $this->createMock(\Doctrine\ORM\Query::class);
        $ormQuery->method('getResult')->willReturn([]);
        $queryBuilder->method('getQuery')->willReturn($ormQuery);

        $entityManager->method('createQueryBuilder')->willReturn($queryBuilder);

        $finder = new Finder('App\\Entity\\Ride', null, $entityManager);
        $finder->executeQuery([], []);
    }

    public function testExecuteOrmQueryReturnsResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $queryBuilder = $this->createMock(\Doctrine\ORM\QueryBuilder::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->willReturnSelf();
        $queryBuilder->method('setMaxResults')->willReturnSelf();

        $ormQuery = $this->createMock(\Doctrine\ORM\Query::class);
        $ormQuery->method('getResult')->willReturn(['entity1', 'entity2']);
        $queryBuilder->method('getQuery')->willReturn($ormQuery);

        $entityManager->method('createQueryBuilder')->willReturn($queryBuilder);

        $finder = new Finder('App\\Entity\\Ride', null, $entityManager);

        $result = $finder->executeQuery([], []);

        $this->assertSame(['entity1', 'entity2'], $result);
    }

    public function testExecuteOrmQueryWithOrmQuery(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $queryBuilder = $this->createMock(\Doctrine\ORM\QueryBuilder::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->willReturnSelf();
        $queryBuilder->method('setMaxResults')->willReturnSelf();
        $queryBuilder->method('getRootAliases')->willReturn(['e']);
        $queryBuilder->method('expr')->willReturn(new \Doctrine\ORM\Query\Expr());
        $queryBuilder->method('andWhere')->willReturnSelf();
        $queryBuilder->method('setParameter')->willReturnSelf();

        $ormQuery = $this->createMock(\Doctrine\ORM\Query::class);
        $ormQuery->method('getResult')->willReturn([]);
        $queryBuilder->method('getQuery')->willReturn($ormQuery);

        $entityManager->method('createQueryBuilder')->willReturn($queryBuilder);

        $booleanQuery = new \MalteHuebner\DataQueryBundle\Query\BooleanQuery();
        $booleanQuery->setPropertyName('enabled');
        $booleanQuery->setValue(true);

        $finder = new Finder('App\\Entity\\Ride', null, $entityManager);

        $result = $finder->executeQuery([$booleanQuery], []);

        $this->assertIsArray($result);
    }

    public function testExecuteOrmQueryWithSizeParameter(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $queryBuilder = $this->createMock(\Doctrine\ORM\QueryBuilder::class);
        $queryBuilder->method('select')->willReturnSelf();
        $queryBuilder->method('from')->willReturnSelf();
        $queryBuilder->method('setMaxResults')->willReturnSelf();

        $ormQuery = $this->createMock(\Doctrine\ORM\Query::class);
        $ormQuery->method('getResult')->willReturn([]);
        $queryBuilder->method('getQuery')->willReturn($ormQuery);

        $entityManager->method('createQueryBuilder')->willReturn($queryBuilder);

        $sizeParameter = new SizeParameter();
        $sizeParameter->setEntityFqcn('App\\Entity\\Ride');
        $sizeParameter->setSize(50);

        $finder = new Finder('App\\Entity\\Ride', null, $entityManager);

        $result = $finder->executeQuery([], [$sizeParameter]);

        $this->assertIsArray($result);
    }
}
