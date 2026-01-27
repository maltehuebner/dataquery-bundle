<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\ParameterFieldList;

use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldList;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldListFactory;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Parameter\FromParameter;
use MalteHuebner\DataQueryBundle\Parameter\OrderDistanceParameter;
use MalteHuebner\DataQueryBundle\Parameter\OrderParameter;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use MalteHuebner\DataQueryBundle\Parameter\StartValueParameter;
use PHPUnit\Framework\TestCase;

class ParameterFieldListFactoryTest extends TestCase
{
    private ParameterFieldListFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ParameterFieldListFactory();
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(ParameterFieldListFactoryInterface::class, $this->factory);
    }

    public function testCreateForSizeParameter(): void
    {
        $result = $this->factory->createForFqcn(SizeParameter::class);

        $this->assertInstanceOf(ParameterFieldList::class, $result);
        $this->assertTrue($result->hasField('setSize'));

        $fields = $result->getList()['setSize'];
        $this->assertSame('int', $fields[0]->getType());
        $this->assertSame('size', $fields[0]->getParameterName());
    }

    public function testCreateForFromParameter(): void
    {
        $result = $this->factory->createForFqcn(FromParameter::class);

        $this->assertTrue($result->hasField('setFrom'));

        $fields = $result->getList()['setFrom'];
        $this->assertSame('int', $fields[0]->getType());
        $this->assertSame('from', $fields[0]->getParameterName());
    }

    public function testCreateForOrderParameter(): void
    {
        $result = $this->factory->createForFqcn(OrderParameter::class);

        $this->assertTrue($result->hasField('setPropertyName'));
        $this->assertTrue($result->hasField('setDirection'));

        $propertyFields = $result->getList()['setPropertyName'];
        $this->assertSame('string', $propertyFields[0]->getType());
        $this->assertSame('orderBy', $propertyFields[0]->getParameterName());

        $directionFields = $result->getList()['setDirection'];
        $this->assertSame('string', $directionFields[0]->getType());
        $this->assertSame('orderDirection', $directionFields[0]->getParameterName());
    }

    public function testCreateForStartValueParameter(): void
    {
        $result = $this->factory->createForFqcn(StartValueParameter::class);

        $this->assertTrue($result->hasField('setStartValue'));

        $fields = $result->getList()['setStartValue'];
        $this->assertSame('mixed', $fields[0]->getType());
        $this->assertSame('startValue', $fields[0]->getParameterName());
    }

    public function testCreateForOrderDistanceParameter(): void
    {
        $result = $this->factory->createForFqcn(OrderDistanceParameter::class);

        $this->assertTrue($result->hasField('setLatitude'));
        $this->assertTrue($result->hasField('setLongitude'));
        $this->assertTrue($result->hasField('setDirection'));

        $latFields = $result->getList()['setLatitude'];
        $this->assertSame('float', $latFields[0]->getType());
        $this->assertSame('centerLatitude', $latFields[0]->getParameterName());

        $lonFields = $result->getList()['setLongitude'];
        $this->assertSame('float', $lonFields[0]->getType());
        $this->assertSame('centerLongitude', $lonFields[0]->getParameterName());

        $dirFields = $result->getList()['setDirection'];
        $this->assertSame('string', $dirFields[0]->getType());
        $this->assertSame('distanceOrderDirection', $dirFields[0]->getParameterName());
    }

    public function testStartValueParameterInheritsOrderParameterFields(): void
    {
        $result = $this->factory->createForFqcn(StartValueParameter::class);

        // inherited from OrderParameter
        $this->assertTrue($result->hasField('setPropertyName'));
        $this->assertTrue($result->hasField('setDirection'));

        // own field
        $this->assertTrue($result->hasField('setStartValue'));
    }
}
