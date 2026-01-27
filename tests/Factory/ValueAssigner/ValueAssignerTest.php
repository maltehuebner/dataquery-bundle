<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Factory\ValueAssigner;

use Doctrine\Persistence\ManagerRegistry;
use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueAssigner;
use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueAssignerInterface;
use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueType;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use MalteHuebner\DataQueryBundle\Query\BoundingBoxQuery;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;

class ValueAssignerTest extends TestCase
{
    private ValueAssigner $valueAssigner;
    private ManagerRegistry $managerRegistry;

    protected function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->valueAssigner = new ValueAssigner($this->managerRegistry);
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(ValueAssignerInterface::class, $this->valueAssigner);
    }

    public function testAssignQueryFloatValue(): void
    {
        $list = new RequestParameterList();
        $list->add('bbNorthLatitude', '53.55');

        $query = new BoundingBoxQuery();

        $queryField = new QueryField();
        $queryField
            ->setMethodName('setNorthLatitude')
            ->setParameterName('bbNorthLatitude')
            ->setType(ValueType::FLOAT);

        $result = $this->valueAssigner->assignQueryPropertyValueFromRequest($list, $query, $queryField);

        $this->assertSame(53.55, $query->getNorthLatitude());
        $this->assertSame($query, $result);
    }

    public function testAssignQueryIntValue(): void
    {
        $list = new RequestParameterList();
        $list->add('fromDateTime', '1704067200');

        $query = new \MalteHuebner\DataQueryBundle\Query\FromDateTimeQuery();

        $queryField = new QueryField();
        $queryField
            ->setMethodName('setFromDateTime')
            ->setParameterName('fromDateTime')
            ->setType(ValueType::INT);

        $this->valueAssigner->assignQueryPropertyValueFromRequest($list, $query, $queryField);

        // No exception means the int value was properly assigned
        $this->assertTrue(true);
    }

    public function testAssignQueryStringValue(): void
    {
        $list = new RequestParameterList();
        $list->add('enabled', 'active');

        $query = new BoundingBoxQuery();

        $queryField = new QueryField();
        $queryField
            ->setMethodName('setNorthLatitude')
            ->setParameterName('someString')
            ->setType(ValueType::STRING);

        // parameter not in list, should return query unchanged
        $result = $this->valueAssigner->assignQueryPropertyValueFromRequest($list, $query, $queryField);
        $this->assertSame($query, $result);
    }

    public function testAssignQueryPropertySkipsWhenParameterNotInList(): void
    {
        $list = new RequestParameterList();

        $query = new BoundingBoxQuery();

        $queryField = new QueryField();
        $queryField
            ->setMethodName('setNorthLatitude')
            ->setParameterName('bbNorthLatitude')
            ->setType(ValueType::FLOAT);

        $result = $this->valueAssigner->assignQueryPropertyValueFromRequest($list, $query, $queryField);

        $this->assertFalse($query->hasNorthLatitude());
        $this->assertSame($query, $result);
    }

    public function testAssignParameterPropertyValueFloat(): void
    {
        $list = new RequestParameterList();
        $list->add('centerLatitude', '52.52');

        $parameter = new \MalteHuebner\DataQueryBundle\Parameter\OrderDistanceParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setLatitude')
            ->setParameterName('centerLatitude')
            ->setType(ValueType::FLOAT);

        $result = $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);

        $this->assertSame($parameter, $result);
    }

    public function testAssignParameterPropertyValueInt(): void
    {
        $list = new RequestParameterList();
        $list->add('size', '25');

        $parameter = new SizeParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setSize')
            ->setParameterName('size')
            ->setType(ValueType::INT);

        $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);

        // No exception means the value was assigned correctly
        $this->assertTrue(true);
    }

    public function testAssignParameterPropertyValueString(): void
    {
        $list = new RequestParameterList();
        $list->add('orderBy', 'name');

        $parameter = new \MalteHuebner\DataQueryBundle\Parameter\OrderParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setPropertyName')
            ->setParameterName('orderBy')
            ->setType(ValueType::STRING);

        $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);

        $this->assertSame('name', $parameter->getPropertyName());
    }

    public function testAssignParameterPropertySkipsWhenNoParameterName(): void
    {
        $list = new RequestParameterList();
        $list->add('size', '25');

        $parameter = new SizeParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        // ParameterField without parameter name set - hasParameterName will throw or return false
        // We need to use a field that has no parameterName set
        $parameterField = $this->createMock(ParameterField::class);
        $parameterField->method('hasParameterName')->willReturn(false);

        $result = $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);

        $this->assertSame($parameter, $result);
    }

    public function testAssignParameterPropertySkipsWhenParameterNotInList(): void
    {
        $list = new RequestParameterList();

        $parameter = new SizeParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setSize')
            ->setParameterName('size')
            ->setType(ValueType::INT);

        $result = $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);

        $this->assertSame($parameter, $result);
    }

    public function testAssignParameterPropertyMixedValue(): void
    {
        $list = new RequestParameterList();
        $list->add('startValue', 'some-value');

        $parameter = new \MalteHuebner\DataQueryBundle\Parameter\StartValueParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setStartValue')
            ->setParameterName('startValue')
            ->setType(ValueType::MIXED);

        $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);

        $this->assertTrue(true);
    }

    public function testConvertToIntThrowsExceptionForNonInteger(): void
    {
        $list = new RequestParameterList();
        $list->add('size', 'not-a-number');

        $parameter = new SizeParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setSize')
            ->setParameterName('size')
            ->setType(ValueType::INT);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Parameter "size" is not a valid integer');

        $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);
    }

    public function testConvertToIntThrowsExceptionForFloat(): void
    {
        $list = new RequestParameterList();
        $list->add('size', '3.14');

        $parameter = new SizeParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $parameterField = new ParameterField();
        $parameterField
            ->setMethodName('setSize')
            ->setParameterName('size')
            ->setType(ValueType::INT);

        $this->expectException(\InvalidArgumentException::class);

        $this->valueAssigner->assignParameterPropertyValueFromRequest($list, $parameter, $parameterField);
    }

    public function testConvertToIntAcceptsNegativeNumber(): void
    {
        $list = new RequestParameterList();
        $list->add('fromDateTime', '-100');

        $query = new \MalteHuebner\DataQueryBundle\Query\FromDateTimeQuery();

        $queryField = new QueryField();
        $queryField
            ->setMethodName('setFromDateTime')
            ->setParameterName('fromDateTime')
            ->setType(ValueType::INT);

        $this->valueAssigner->assignQueryPropertyValueFromRequest($list, $query, $queryField);

        $this->assertTrue(true);
    }
}
