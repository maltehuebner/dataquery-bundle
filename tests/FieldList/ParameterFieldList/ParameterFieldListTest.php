<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\ParameterFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractFieldList;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldList;
use PHPUnit\Framework\TestCase;

class ParameterFieldListTest extends TestCase
{
    public function testExtendsAbstractFieldList(): void
    {
        $list = new ParameterFieldList();

        $this->assertInstanceOf(AbstractFieldList::class, $list);
    }

    public function testGetListReturnsEmptyArrayInitially(): void
    {
        $list = new ParameterFieldList();

        $this->assertSame([], $list->getList());
    }

    public function testAddField(): void
    {
        $list = new ParameterFieldList();
        $field = new ParameterField();
        $field->setParameterName('size');

        $result = $list->addField('setSize', $field);

        $this->assertSame($list, $result);
        $this->assertTrue($list->hasField('setSize'));
    }

    public function testAddMultipleFieldsSameName(): void
    {
        $list = new ParameterFieldList();
        $field1 = new ParameterField();
        $field2 = new ParameterField();

        $list->addField('setSize', $field1);
        $list->addField('setSize', $field2);

        $fields = $list->getList()['setSize'];
        $this->assertCount(2, $fields);
    }

    public function testHasFieldReturnsFalseForNonExisting(): void
    {
        $list = new ParameterFieldList();

        $this->assertFalse($list->hasField('nonexistent'));
    }

    public function testAddMultipleFieldsDifferentNames(): void
    {
        $list = new ParameterFieldList();
        $field1 = new ParameterField();
        $field2 = new ParameterField();

        $list->addField('setSize', $field1);
        $list->addField('setFrom', $field2);

        $this->assertTrue($list->hasField('setSize'));
        $this->assertTrue($list->hasField('setFrom'));
    }
}
