<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Manager;

use MalteHuebner\DataQueryBundle\Manager\QueryManager;
use MalteHuebner\DataQueryBundle\Manager\QueryManagerInterface;
use MalteHuebner\DataQueryBundle\Query\BooleanQuery;
use MalteHuebner\DataQueryBundle\Query\BoundingBoxQuery;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use PHPUnit\Framework\TestCase;

class QueryManagerTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $manager = new QueryManager();

        $this->assertInstanceOf(QueryManagerInterface::class, $manager);
    }

    public function testGetQueryListReturnsEmptyArrayInitially(): void
    {
        $manager = new QueryManager();

        $this->assertSame([], $manager->getQueryList());
    }

    public function testAddQuery(): void
    {
        $manager = new QueryManager();
        $query = new BooleanQuery();

        $result = $manager->addQuery($query);

        $this->assertInstanceOf(QueryManagerInterface::class, $result);
        $this->assertCount(1, $manager->getQueryList());
        $this->assertSame($query, $manager->getQueryList()[0]);
    }

    public function testAddMultipleQueries(): void
    {
        $manager = new QueryManager();
        $query1 = new BooleanQuery();
        $query2 = new BoundingBoxQuery();

        $manager->addQuery($query1);
        $manager->addQuery($query2);

        $this->assertCount(2, $manager->getQueryList());
        $this->assertSame($query1, $manager->getQueryList()[0]);
        $this->assertSame($query2, $manager->getQueryList()[1]);
    }

    public function testFluentInterface(): void
    {
        $manager = new QueryManager();
        $query1 = new BooleanQuery();
        $query2 = new BoundingBoxQuery();

        $result = $manager
            ->addQuery($query1)
            ->addQuery($query2);

        $this->assertInstanceOf(QueryManagerInterface::class, $result);
        $this->assertCount(2, $manager->getQueryList());
    }

    public function testAddSameQueryTwice(): void
    {
        $manager = new QueryManager();
        $query = new BooleanQuery();

        $manager->addQuery($query);
        $manager->addQuery($query);

        $this->assertCount(2, $manager->getQueryList());
    }
}
