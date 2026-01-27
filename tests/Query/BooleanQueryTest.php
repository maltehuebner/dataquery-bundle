<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Query;

use MalteHuebner\DataQueryBundle\Query\BooleanQuery;
use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use PHPUnit\Framework\TestCase;

class BooleanQueryTest extends TestCase
{
    public function testImplementsQueryInterface(): void
    {
        $query = new BooleanQuery();

        $this->assertInstanceOf(QueryInterface::class, $query);
    }

    public function testImplementsOrmQueryInterface(): void
    {
        $query = new BooleanQuery();

        $this->assertInstanceOf(OrmQueryInterface::class, $query);
    }

    public function testImplementsElasticQueryInterface(): void
    {
        $query = new BooleanQuery();

        $this->assertInstanceOf(ElasticQueryInterface::class, $query);
    }

    public function testSetAndGetPropertyName(): void
    {
        $query = new BooleanQuery();
        $result = $query->setPropertyName('enabled');

        $this->assertSame('enabled', $query->getPropertyName());
        $this->assertSame($query, $result);
    }

    public function testSetAndGetValue(): void
    {
        $query = new BooleanQuery();
        $result = $query->setValue(true);

        $this->assertTrue($query->getValue());
        $this->assertSame($query, $result);
    }

    public function testDefaultValueIsFalse(): void
    {
        $query = new BooleanQuery();

        $this->assertFalse($query->getValue());
    }

    public function testSetEntityFqcn(): void
    {
        $query = new BooleanQuery();
        $result = $query->setEntityFqcn('App\\Entity\\Ride');

        $this->assertSame('App\\Entity\\Ride', $query->getEntityFqcn());
        $this->assertSame($query, $result);
    }

    public function testIsOverridenByReturnsEmptyArray(): void
    {
        $query = new BooleanQuery();

        $this->assertSame([], $query->isOverridenBy());
    }

    public function testCreateElasticQuery(): void
    {
        $query = new BooleanQuery();
        $query->setPropertyName('enabled');
        $query->setValue(true);

        $elasticQuery = $query->createElasticQuery();

        $this->assertInstanceOf(\Elastica\Query\Term::class, $elasticQuery);
    }

    public function testFluentInterface(): void
    {
        $query = new BooleanQuery();

        $result = $query
            ->setPropertyName('active')
            ->setValue(true);

        $this->assertInstanceOf(BooleanQuery::class, $result);
        $this->assertSame('active', $result->getPropertyName());
        $this->assertTrue($result->getValue());
    }
}
