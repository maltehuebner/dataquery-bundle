<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\ParameterFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use PHPUnit\Framework\TestCase;

class ParameterFieldTest extends TestCase
{
    public function testExtendsAbstractField(): void
    {
        $field = new ParameterField();

        $this->assertInstanceOf(AbstractField::class, $field);
    }

    public function testSetAndGetParameterName(): void
    {
        $field = new ParameterField();
        $result = $field->setParameterName('size');

        $this->assertSame('size', $field->getParameterName());
        $this->assertSame($field, $result);
    }

    public function testHasParameterNameAfterSet(): void
    {
        $field = new ParameterField();
        $field->setParameterName('size');

        $this->assertTrue($field->hasParameterName());
    }

    public function testRequiresQueryableDefaultsFalse(): void
    {
        $field = new ParameterField();

        $this->assertFalse($field->requiresQueryable());
    }

    public function testSetAndRequiresQueryable(): void
    {
        $field = new ParameterField();
        $result = $field->setRequiresQueryable(true);

        $this->assertTrue($field->requiresQueryable());
        $this->assertSame($field, $result);
    }

    public function testSetAndGetDateTimeFormat(): void
    {
        $field = new ParameterField();
        $result = $field->setDateTimeFormat('yyyy-MM-dd');

        $this->assertSame('yyyy-MM-dd', $field->getDateTimeFormat());
        $this->assertSame($field, $result);
    }

    public function testSetAndGetDateTimePattern(): void
    {
        $field = new ParameterField();
        $result = $field->setDateTimePattern('Y-m-d');

        $this->assertSame('Y-m-d', $field->getDateTimePattern());
        $this->assertSame($field, $result);
    }

    public function testInheritedMethods(): void
    {
        $field = new ParameterField();
        $field->setType('int');
        $field->setPropertyName('size');
        $field->setMethodName('setSize');

        $this->assertSame('int', $field->getType());
        $this->assertSame('size', $field->getPropertyName());
        $this->assertSame('setSize', $field->getMethodName());
    }
}
