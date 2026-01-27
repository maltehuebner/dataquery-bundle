<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Query;

use MalteHuebner\DataQueryBundle\Query\DateTimeQueryInterface;
use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\FromDateTimeQuery;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use PHPUnit\Framework\TestCase;

class FromDateTimeQueryTest extends TestCase
{
    public function testImplementsQueryInterface(): void
    {
        $query = new FromDateTimeQuery();

        $this->assertInstanceOf(QueryInterface::class, $query);
    }

    public function testImplementsOrmQueryInterface(): void
    {
        $query = new FromDateTimeQuery();

        $this->assertInstanceOf(OrmQueryInterface::class, $query);
    }

    public function testImplementsElasticQueryInterface(): void
    {
        $query = new FromDateTimeQuery();

        $this->assertInstanceOf(ElasticQueryInterface::class, $query);
    }

    public function testImplementsDateTimeQueryInterface(): void
    {
        $query = new FromDateTimeQuery();

        $this->assertInstanceOf(DateTimeQueryInterface::class, $query);
    }

    public function testSetFromDateTime(): void
    {
        $query = new FromDateTimeQuery();
        $result = $query->setFromDateTime(1704067200);

        $this->assertSame($query, $result);
    }

    public function testIsOverridenByReturnsEmptyArray(): void
    {
        $query = new FromDateTimeQuery();

        $this->assertSame([], $query->isOverridenBy());
    }

    public function testSetEntityFqcn(): void
    {
        $query = new FromDateTimeQuery();
        $query->setEntityFqcn('App\\Entity\\Ride');

        $this->assertSame('App\\Entity\\Ride', $query->getEntityFqcn());
    }

    public function testSetDateTimePattern(): void
    {
        $query = new FromDateTimeQuery();
        $result = $query->setDateTimePattern('Y-m-d');

        $this->assertInstanceOf(DateTimeQueryInterface::class, $result);
    }

    public function testSetDateTimeFormat(): void
    {
        $query = new FromDateTimeQuery();
        $result = $query->setDateTimeFormat('yyyy-MM-dd');

        $this->assertInstanceOf(DateTimeQueryInterface::class, $result);
    }

    public function testSetPropertyName(): void
    {
        $query = new FromDateTimeQuery();
        $result = $query->setPropertyName('dateTime');

        $this->assertInstanceOf(DateTimeQueryInterface::class, $result);
    }

    public function testCreateElasticQuery(): void
    {
        $query = new FromDateTimeQuery();
        $query->setFromDateTime(1704067200);
        $query->setDateTimePattern('Y-m-d');
        $query->setDateTimeFormat('yyyy-MM-dd');
        $query->setPropertyName('dateTime');

        $elasticQuery = $query->createElasticQuery();

        $this->assertInstanceOf(\Elastica\Query\Range::class, $elasticQuery);
    }
}
