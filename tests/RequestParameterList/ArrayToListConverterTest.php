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

    public function testConvertNonStringValueThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);

        ArrayToListConverter::convert([
            'size' => 25,
        ]);
    }
}
