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

    public function testConvertIntegerValueToString(): void
    {
        $result = ArrayToListConverter::convert([
            'size' => 25,
        ]);

        $this->assertSame('25', $result->get('size'));
    }

    public function testConvertArrayValueToCommaSeparatedString(): void
    {
        $result = ArrayToListConverter::convert([
            'tags' => ['foo', 'bar', 'baz'],
        ]);

        $this->assertSame('foo,bar,baz', $result->get('tags'));
    }

    public function testConvertFloatValueToString(): void
    {
        $result = ArrayToListConverter::convert([
            'latitude' => 52.52,
        ]);

        $this->assertSame('52.52', $result->get('latitude'));
    }

    public function testConvertBooleanValueToString(): void
    {
        $result = ArrayToListConverter::convert([
            'enabled' => true,
        ]);

        $this->assertSame('1', $result->get('enabled'));
    }
}
