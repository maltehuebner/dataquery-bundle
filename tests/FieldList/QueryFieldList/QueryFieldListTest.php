<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\QueryFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractFieldList;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldList;
use PHPUnit\Framework\TestCase;

class QueryFieldListTest extends TestCase
{
    public function testExtendsAbstractFieldList(): void
    {
        $list = new QueryFieldList();

        $this->assertInstanceOf(AbstractFieldList::class, $list);
    }

    public function testGetListReturnsEmptyArrayInitially(): void
    {
        $list = new QueryFieldList();

        $this->assertSame([], $list->getList());
    }

    public function testAddField(): void
    {
        $list = new QueryFieldList();
        $field = new QueryField();
        $field->setParameterName('year');

        $result = $list->addField('setYear', $field);

        $this->assertSame($list, $result);
        $this->assertTrue($list->hasField('setYear'));
    }

    public function testAddMultipleFieldsSameName(): void
    {
        $list = new QueryFieldList();
        $field1 = new QueryField();
        $field2 = new QueryField();

        $list->addField('setYear', $field1);
        $list->addField('setYear', $field2);

        $fields = $list->getList()['setYear'];
        $this->assertCount(2, $fields);
    }

    public function testHasFieldReturnsFalseForNonExisting(): void
    {
        $list = new QueryFieldList();

        $this->assertFalse($list->hasField('nonexistent'));
    }

    public function testAddMultipleFieldsDifferentNames(): void
    {
        $list = new QueryFieldList();
        $field1 = new QueryField();
        $field2 = new QueryField();

        $list->addField('setYear', $field1);
        $list->addField('setMonth', $field2);

        $this->assertTrue($list->hasField('setYear'));
        $this->assertTrue($list->hasField('setMonth'));
        $this->assertCount(2, $list->getList());
    }
}
