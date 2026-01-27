<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Query;

use MalteHuebner\DataQueryBundle\Query\DateTimeQueryInterface;
use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use MalteHuebner\DataQueryBundle\Query\UntilDateTimeQuery;
use PHPUnit\Framework\TestCase;

class UntilDateTimeQueryTest extends TestCase
{
    public function testImplementsQueryInterface(): void
    {
        $query = new UntilDateTimeQuery();

        $this->assertInstanceOf(QueryInterface::class, $query);
    }

    public function testImplementsOrmQueryInterface(): void
    {
        $query = new UntilDateTimeQuery();

        $this->assertInstanceOf(OrmQueryInterface::class, $query);
    }

    public function testImplementsElasticQueryInterface(): void
    {
        $query = new UntilDateTimeQuery();

        $this->assertInstanceOf(ElasticQueryInterface::class, $query);
    }

    public function testImplementsDateTimeQueryInterface(): void
    {
        $query = new UntilDateTimeQuery();

        $this->assertInstanceOf(DateTimeQueryInterface::class, $query);
    }

    public function testSetUntilDateTime(): void
    {
        $query = new UntilDateTimeQuery();
        $result = $query->setUntilDateTime(1704067200);

        $this->assertSame($query, $result);
    }

    public function testIsOverridenByReturnsEmptyArray(): void
    {
        $query = new UntilDateTimeQuery();

        $this->assertSame([], $query->isOverridenBy());
    }

    public function testSetEntityFqcn(): void
    {
        $query = new UntilDateTimeQuery();
        $query->setEntityFqcn('App\\Entity\\Ride');

        $this->assertSame('App\\Entity\\Ride', $query->getEntityFqcn());
    }

    public function testSetDateTimePattern(): void
    {
        $query = new UntilDateTimeQuery();
        $result = $query->setDateTimePattern('Y-m-d');

        $this->assertInstanceOf(DateTimeQueryInterface::class, $result);
    }

    public function testSetDateTimeFormat(): void
    {
        $query = new UntilDateTimeQuery();
        $result = $query->setDateTimeFormat('yyyy-MM-dd');

        $this->assertInstanceOf(DateTimeQueryInterface::class, $result);
    }

    public function testSetPropertyName(): void
    {
        $query = new UntilDateTimeQuery();
        $result = $query->setPropertyName('dateTime');

        $this->assertInstanceOf(DateTimeQueryInterface::class, $result);
    }

    public function testCreateElasticQuery(): void
    {
        $query = new UntilDateTimeQuery();
        $query->setUntilDateTime(1704067200);
        $query->setDateTimePattern('Y-m-d');
        $query->setDateTimeFormat('yyyy-MM-dd');
        $query->setPropertyName('dateTime');

        $elasticQuery = $query->createElasticQuery();

        $this->assertInstanceOf(\Elastica\Query\Range::class, $elasticQuery);
    }
}
