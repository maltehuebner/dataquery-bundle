<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Query;

use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use MalteHuebner\DataQueryBundle\Query\RadiusQuery;
use PHPUnit\Framework\TestCase;

class RadiusQueryTest extends TestCase
{
    public function testImplementsQueryInterface(): void
    {
        $query = new RadiusQuery();

        $this->assertInstanceOf(QueryInterface::class, $query);
    }

    public function testImplementsOrmQueryInterface(): void
    {
        $query = new RadiusQuery();

        $this->assertInstanceOf(OrmQueryInterface::class, $query);
    }

    public function testImplementsElasticQueryInterface(): void
    {
        $query = new RadiusQuery();

        $this->assertInstanceOf(ElasticQueryInterface::class, $query);
    }

    public function testSetCenterLatitude(): void
    {
        $query = new RadiusQuery();
        $result = $query->setCenterLatitude(52.52);

        $this->assertSame($query, $result);
    }

    public function testSetCenterLongitude(): void
    {
        $query = new RadiusQuery();
        $result = $query->setCenterLongitude(13.405);

        $this->assertSame($query, $result);
    }

    public function testSetRadius(): void
    {
        $query = new RadiusQuery();
        $result = $query->setRadius(50.0);

        $this->assertSame($query, $result);
    }

    public function testIsOverridenByReturnsEmptyArray(): void
    {
        $query = new RadiusQuery();

        $this->assertSame([], $query->isOverridenBy());
    }

    public function testSetEntityFqcn(): void
    {
        $query = new RadiusQuery();
        $query->setEntityFqcn('App\\Entity\\Location');

        $this->assertSame('App\\Entity\\Location', $query->getEntityFqcn());
    }

    public function testCreateElasticQuery(): void
    {
        $query = new RadiusQuery();
        $query->setCenterLatitude(52.52);
        $query->setCenterLongitude(13.405);
        $query->setRadius(50.0);

        $elasticQuery = $query->createElasticQuery();

        $this->assertInstanceOf(\Elastica\Query\GeoDistance::class, $elasticQuery);
    }
}
