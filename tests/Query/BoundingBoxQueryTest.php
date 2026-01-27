<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Query;

use MalteHuebner\DataQueryBundle\Query\BoundingBoxQuery;
use MalteHuebner\DataQueryBundle\Query\ElasticQueryInterface;
use MalteHuebner\DataQueryBundle\Query\OrmQueryInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use PHPUnit\Framework\TestCase;

class BoundingBoxQueryTest extends TestCase
{
    public function testImplementsQueryInterface(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertInstanceOf(QueryInterface::class, $query);
    }

    public function testImplementsOrmQueryInterface(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertInstanceOf(OrmQueryInterface::class, $query);
    }

    public function testImplementsElasticQueryInterface(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertInstanceOf(ElasticQueryInterface::class, $query);
    }

    public function testSetAndGetNorthLatitude(): void
    {
        $query = new BoundingBoxQuery();
        $result = $query->setNorthLatitude(53.55);

        $this->assertSame(53.55, $query->getNorthLatitude());
        $this->assertSame($query, $result);
    }

    public function testSetAndGetSouthLatitude(): void
    {
        $query = new BoundingBoxQuery();
        $result = $query->setSouthLatitude(52.50);

        $this->assertSame(52.50, $query->getSouthLatitude());
        $this->assertSame($query, $result);
    }

    public function testSetAndGetEastLongitude(): void
    {
        $query = new BoundingBoxQuery();
        $result = $query->setEastLongitude(10.0);

        $this->assertSame(10.0, $query->getEastLongitude());
        $this->assertSame($query, $result);
    }

    public function testSetAndGetWestLongitude(): void
    {
        $query = new BoundingBoxQuery();
        $result = $query->setWestLongitude(9.5);

        $this->assertSame(9.5, $query->getWestLongitude());
        $this->assertSame($query, $result);
    }

    public function testHasNorthLatitudeReturnsFalseInitially(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertFalse($query->hasNorthLatitude());
    }

    public function testHasNorthLatitudeReturnsTrueAfterSet(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);

        $this->assertTrue($query->hasNorthLatitude());
    }

    public function testHasSouthLatitudeReturnsFalseInitially(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertFalse($query->hasSouthLatitude());
    }

    public function testHasSouthLatitudeReturnsTrueAfterSet(): void
    {
        $query = new BoundingBoxQuery();
        $query->setSouthLatitude(52.50);

        $this->assertTrue($query->hasSouthLatitude());
    }

    public function testHasEastLongitudeReturnsFalseInitially(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertFalse($query->hasEastLongitude());
    }

    public function testHasEastLongitudeReturnsTrueAfterSet(): void
    {
        $query = new BoundingBoxQuery();
        $query->setEastLongitude(10.0);

        $this->assertTrue($query->hasEastLongitude());
    }

    public function testHasWestLongitudeReturnsFalseInitially(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertFalse($query->hasWestLongitude());
    }

    public function testHasWestLongitudeReturnsTrueAfterSet(): void
    {
        $query = new BoundingBoxQuery();
        $query->setWestLongitude(9.5);

        $this->assertTrue($query->hasWestLongitude());
    }

    public function testIsOverridenByReturnsEmptyArray(): void
    {
        $query = new BoundingBoxQuery();

        $this->assertSame([], $query->isOverridenBy());
    }

    public function testCreateElasticQuery(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setSouthLatitude(52.50);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(9.5);

        $elasticQuery = $query->createElasticQuery();

        $this->assertInstanceOf(\Elastica\Query\GeoBoundingBox::class, $elasticQuery);
    }

    public function testSetEntityFqcn(): void
    {
        $query = new BoundingBoxQuery();
        $query->setEntityFqcn('App\\Entity\\Location');

        $this->assertSame('App\\Entity\\Location', $query->getEntityFqcn());
    }

    public function testNegativeCoordinates(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(-10.0);
        $query->setSouthLatitude(-20.0);
        $query->setEastLongitude(-30.0);
        $query->setWestLongitude(-40.0);

        $this->assertSame(-10.0, $query->getNorthLatitude());
        $this->assertSame(-20.0, $query->getSouthLatitude());
        $this->assertSame(-30.0, $query->getEastLongitude());
        $this->assertSame(-40.0, $query->getWestLongitude());
    }
}
