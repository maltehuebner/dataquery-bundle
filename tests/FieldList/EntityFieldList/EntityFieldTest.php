<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\EntityFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityField;
use PHPUnit\Framework\TestCase;

class EntityFieldTest extends TestCase
{
    public function testExtendsAbstractField(): void
    {
        $field = new EntityField();

        $this->assertInstanceOf(AbstractField::class, $field);
    }

    public function testQueryableDefaultsFalse(): void
    {
        $field = new EntityField();

        $this->assertFalse($field->isQueryable());
    }

    public function testSetAndIsQueryable(): void
    {
        $field = new EntityField();
        $result = $field->setQueryable(true);

        $this->assertTrue($field->isQueryable());
        $this->assertSame($field, $result);
    }

    public function testSortableDefaultsFalse(): void
    {
        $field = new EntityField();

        $this->assertFalse($field->isSortable());
    }

    public function testSetAndIsSortable(): void
    {
        $field = new EntityField();
        $result = $field->setSortable(true);

        $this->assertTrue($field->isSortable());
        $this->assertSame($field, $result);
    }

    public function testDefaultQueryBoolDefaultsFalse(): void
    {
        $field = new EntityField();

        $this->assertFalse($field->hasDefaultQueryBool());
    }

    public function testSetAndHasDefaultQueryBool(): void
    {
        $field = new EntityField();
        $result = $field->setDefaultQueryBool(true);

        $this->assertTrue($field->hasDefaultQueryBool());
        $this->assertSame($field, $result);
    }

    public function testDefaultQueryBoolValueDefaultsFalse(): void
    {
        $field = new EntityField();

        $this->assertFalse($field->getDefaultQueryBoolValue());
    }

    public function testSetAndGetDefaultQueryBoolValue(): void
    {
        $field = new EntityField();
        $result = $field->setDefaultQueryBoolValue(true);

        $this->assertTrue($field->getDefaultQueryBoolValue());
        $this->assertSame($field, $result);
    }

    public function testDateTimeFormatDefaultsNull(): void
    {
        $field = new EntityField();

        $this->assertNull($field->getDateTimeFormat());
    }

    public function testSetAndGetDateTimeFormat(): void
    {
        $field = new EntityField();
        $result = $field->setDateTimeFormat('yyyy-MM-dd');

        $this->assertSame('yyyy-MM-dd', $field->getDateTimeFormat());
        $this->assertSame($field, $result);
    }

    public function testDateTimePatternDefaultsNull(): void
    {
        $field = new EntityField();

        $this->assertNull($field->getDateTimePattern());
    }

    public function testSetAndGetDateTimePattern(): void
    {
        $field = new EntityField();
        $result = $field->setDateTimePattern('Y-m-d');

        $this->assertSame('Y-m-d', $field->getDateTimePattern());
        $this->assertSame($field, $result);
    }

    public function testInheritedType(): void
    {
        $field = new EntityField();
        $field->setType('string');

        $this->assertSame('string', $field->getType());
    }

    public function testInheritedPropertyName(): void
    {
        $field = new EntityField();
        $field->setPropertyName('title');

        $this->assertSame('title', $field->getPropertyName());
    }

    public function testInheritedMethodName(): void
    {
        $field = new EntityField();
        $field->setMethodName('getTitle');

        $this->assertSame('getTitle', $field->getMethodName());
    }

    public function testFullConfiguration(): void
    {
        $field = new EntityField();
        $field
            ->setPropertyName('dateTime')
            ->setType('DateTime')
            ->setQueryable(true)
            ->setSortable(true)
            ->setDefaultQueryBool(true)
            ->setDefaultQueryBoolValue(false)
            ->setDateTimeFormat('yyyy-MM-dd')
            ->setDateTimePattern('Y-m-d');

        $this->assertSame('dateTime', $field->getPropertyName());
        $this->assertSame('DateTime', $field->getType());
        $this->assertTrue($field->isQueryable());
        $this->assertTrue($field->isSortable());
        $this->assertTrue($field->hasDefaultQueryBool());
        $this->assertFalse($field->getDefaultQueryBoolValue());
        $this->assertSame('yyyy-MM-dd', $field->getDateTimeFormat());
        $this->assertSame('Y-m-d', $field->getDateTimePattern());
    }
}
