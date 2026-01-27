<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\QueryFieldList;

use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldList;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldListFactory;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Query\BooleanQuery;
use MalteHuebner\DataQueryBundle\Query\BoundingBoxQuery;
use MalteHuebner\DataQueryBundle\Query\FromDateTimeQuery;
use MalteHuebner\DataQueryBundle\Query\RadiusQuery;
use MalteHuebner\DataQueryBundle\Query\UntilDateTimeQuery;
use PHPUnit\Framework\TestCase;

class QueryFieldListFactoryTest extends TestCase
{
    private QueryFieldListFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new QueryFieldListFactory();
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(QueryFieldListFactoryInterface::class, $this->factory);
    }

    public function testCreateForBoundingBoxQuery(): void
    {
        $result = $this->factory->createForFqcn(BoundingBoxQuery::class);

        $this->assertInstanceOf(QueryFieldList::class, $result);
        $this->assertTrue($result->hasField('setNorthLatitude'));
        $this->assertTrue($result->hasField('setSouthLatitude'));
        $this->assertTrue($result->hasField('setEastLongitude'));
        $this->assertTrue($result->hasField('setWestLongitude'));
    }

    public function testBoundingBoxQueryFieldTypes(): void
    {
        $result = $this->factory->createForFqcn(BoundingBoxQuery::class);

        $northLatFields = $result->getList()['setNorthLatitude'];
        $this->assertNotEmpty($northLatFields);
        $field = $northLatFields[0];
        $this->assertSame('float', $field->getType());
        $this->assertSame('bbNorthLatitude', $field->getParameterName());
        $this->assertSame('setNorthLatitude', $field->getMethodName());
    }

    public function testCreateForRadiusQuery(): void
    {
        $result = $this->factory->createForFqcn(RadiusQuery::class);

        $this->assertInstanceOf(QueryFieldList::class, $result);
        $this->assertTrue($result->hasField('setCenterLatitude'));
        $this->assertTrue($result->hasField('setCenterLongitude'));
        $this->assertTrue($result->hasField('setRadius'));
    }

    public function testRadiusQueryFieldParameterNames(): void
    {
        $result = $this->factory->createForFqcn(RadiusQuery::class);

        $latFields = $result->getList()['setCenterLatitude'];
        $this->assertSame('centerLatitude', $latFields[0]->getParameterName());

        $lonFields = $result->getList()['setCenterLongitude'];
        $this->assertSame('centerLongitude', $lonFields[0]->getParameterName());

        $radiusFields = $result->getList()['setRadius'];
        $this->assertSame('radius', $radiusFields[0]->getParameterName());
    }

    public function testCreateForFromDateTimeQuery(): void
    {
        $result = $this->factory->createForFqcn(FromDateTimeQuery::class);

        $this->assertTrue($result->hasField('setFromDateTime'));

        $fields = $result->getList()['setFromDateTime'];
        $this->assertSame('int', $fields[0]->getType());
        $this->assertSame('fromDateTime', $fields[0]->getParameterName());
    }

    public function testCreateForUntilDateTimeQuery(): void
    {
        $result = $this->factory->createForFqcn(UntilDateTimeQuery::class);

        $this->assertTrue($result->hasField('setUntilDateTime'));

        $fields = $result->getList()['setUntilDateTime'];
        $this->assertSame('int', $fields[0]->getType());
        $this->assertSame('untilDateTime', $fields[0]->getParameterName());
    }

    public function testFieldHasNullRepositoryByDefault(): void
    {
        $result = $this->factory->createForFqcn(BoundingBoxQuery::class);

        $fields = $result->getList()['setNorthLatitude'];
        $this->assertNull($fields[0]->getRepository());
        $this->assertNull($fields[0]->getRepositoryMethod());
        $this->assertNull($fields[0]->getAccessor());
    }
}
