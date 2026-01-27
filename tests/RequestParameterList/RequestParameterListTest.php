<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\RequestParameterList;

use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;

class RequestParameterListTest extends TestCase
{
    public function testAddAndGet(): void
    {
        $list = new RequestParameterList();
        $result = $list->add('key1', 'value1');

        $this->assertSame('value1', $list->get('key1'));
        $this->assertSame($list, $result);
    }

    public function testHasReturnsTrueForExistingKey(): void
    {
        $list = new RequestParameterList();
        $list->add('foo', 'bar');

        $this->assertTrue($list->has('foo'));
    }

    public function testHasReturnsFalseForNonExistingKey(): void
    {
        $list = new RequestParameterList();

        $this->assertFalse($list->has('nonexistent'));
    }

    public function testGetListReturnsAllEntries(): void
    {
        $list = new RequestParameterList();
        $list->add('a', '1');
        $list->add('b', '2');
        $list->add('c', '3');

        $expected = ['a' => '1', 'b' => '2', 'c' => '3'];
        $this->assertSame($expected, $list->getList());
    }

    public function testGetListReturnsEmptyArrayInitially(): void
    {
        $list = new RequestParameterList();

        $this->assertSame([], $list->getList());
    }

    public function testAddOverwritesExistingKey(): void
    {
        $list = new RequestParameterList();
        $list->add('key', 'first');
        $list->add('key', 'second');

        $this->assertSame('second', $list->get('key'));
        $this->assertCount(1, $list->getList());
    }

    public function testFluentInterface(): void
    {
        $list = new RequestParameterList();

        $result = $list
            ->add('a', '1')
            ->add('b', '2')
            ->add('c', '3');

        $this->assertInstanceOf(RequestParameterList::class, $result);
        $this->assertCount(3, $result->getList());
    }

    public function testAddWithEmptyStringKey(): void
    {
        $list = new RequestParameterList();
        $list->add('', 'value');

        $this->assertTrue($list->has(''));
        $this->assertSame('value', $list->get(''));
    }

    public function testAddWithEmptyStringValue(): void
    {
        $list = new RequestParameterList();
        $list->add('key', '');

        $this->assertTrue($list->has('key'));
        $this->assertSame('', $list->get('key'));
    }
}
