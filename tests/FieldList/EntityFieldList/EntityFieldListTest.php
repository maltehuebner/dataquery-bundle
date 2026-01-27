<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\EntityFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractFieldList;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityField;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldList;
use PHPUnit\Framework\TestCase;

class EntityFieldListTest extends TestCase
{
    public function testExtendsAbstractFieldList(): void
    {
        $list = new EntityFieldList();

        $this->assertInstanceOf(AbstractFieldList::class, $list);
    }

    public function testGetListReturnsEmptyArrayInitially(): void
    {
        $list = new EntityFieldList();

        $this->assertSame([], $list->getList());
    }

    public function testAddField(): void
    {
        $list = new EntityFieldList();
        $field = new EntityField();
        $field->setPropertyName('title');

        $result = $list->addField('title', $field);

        $this->assertSame($list, $result);
        $this->assertTrue($list->hasField('title'));
    }

    public function testAddMultipleFieldsSameName(): void
    {
        $list = new EntityFieldList();
        $field1 = new EntityField();
        $field1->setQueryable(true);
        $field2 = new EntityField();
        $field2->setSortable(true);

        $list->addField('title', $field1);
        $list->addField('title', $field2);

        $fields = $list->getList()['title'];
        $this->assertCount(2, $fields);
        $this->assertSame($field1, $fields[0]);
        $this->assertSame($field2, $fields[1]);
    }

    public function testHasFieldReturnsFalseForNonExisting(): void
    {
        $list = new EntityFieldList();

        $this->assertFalse($list->hasField('nonexistent'));
    }

    public function testAddMultipleFieldsDifferentNames(): void
    {
        $list = new EntityFieldList();
        $field1 = new EntityField();
        $field2 = new EntityField();

        $list->addField('title', $field1);
        $list->addField('description', $field2);

        $this->assertTrue($list->hasField('title'));
        $this->assertTrue($list->hasField('description'));
        $this->assertCount(2, $list->getList());
    }

    public function testGetListStructure(): void
    {
        $list = new EntityFieldList();
        $field = new EntityField();

        $list->addField('myField', $field);

        $result = $list->getList();
        $this->assertArrayHasKey('myField', $result);
        $this->assertIsArray($result['myField']);
        $this->assertCount(1, $result['myField']);
        $this->assertSame($field, $result['myField'][0]);
    }
}
