<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\RequestParameterList;

use MalteHuebner\DataQueryBundle\RequestParameterList\ArrayToListConverter;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;

class ArrayToListConverterTest extends TestCase
{
    public function testConvertEmptyArray(): void
    {
        $result = ArrayToListConverter::convert([]);

        $this->assertInstanceOf(RequestParameterList::class, $result);
        $this->assertSame([], $result->getList());
    }

    public function testConvertSimpleArray(): void
    {
        $result = ArrayToListConverter::convert([
            'year' => '2024',
            'month' => '6',
        ]);

        $this->assertTrue($result->has('year'));
        $this->assertSame('2024', $result->get('year'));
        $this->assertTrue($result->has('month'));
        $this->assertSame('6', $result->get('month'));
    }

    public function testConvertIntegerValuesToStrings(): void
    {
        $result = ArrayToListConverter::convert([
            'size' => 25,
            'from' => 0,
        ]);

        $this->assertSame('25', $result->get('size'));
        $this->assertSame('0', $result->get('from'));
    }

    public function testConvertFloatValuesToStrings(): void
    {
        $result = ArrayToListConverter::convert([
            'latitude' => 52.52,
        ]);

        $this->assertSame('52.52', $result->get('latitude'));
    }

    public function testConvertArrayValuesToCommaSeparatedString(): void
    {
        $result = ArrayToListConverter::convert([
            'tags' => ['foo', 'bar', 'baz'],
        ]);

        $this->assertSame('foo,bar,baz', $result->get('tags'));
    }

    public function testConvertNestedArrayValues(): void
    {
        $result = ArrayToListConverter::convert([
            'ids' => [1, 2, 3],
        ]);

        $this->assertSame('1,2,3', $result->get('ids'));
    }

    public function testConvertMixedValues(): void
    {
        $result = ArrayToListConverter::convert([
            'name' => 'test',
            'size' => 10,
            'tags' => ['a', 'b'],
            'lat' => 52.5,
        ]);

        $this->assertSame('test', $result->get('name'));
        $this->assertSame('10', $result->get('size'));
        $this->assertSame('a,b', $result->get('tags'));
        $this->assertSame('52.5', $result->get('lat'));
    }

    public function testConvertBooleanValues(): void
    {
        $result = ArrayToListConverter::convert([
            'enabled' => true,
            'disabled' => false,
        ]);

        $this->assertSame('1', $result->get('enabled'));
        $this->assertSame('', $result->get('disabled'));
    }
}
