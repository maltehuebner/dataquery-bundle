<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\RequestParameterList;

use MalteHuebner\DataQueryBundle\RequestParameterList\QueryStringToListConverter;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;

class QueryStringToListConverterTest extends TestCase
{
    public function testConvertSimpleQueryString(): void
    {
        $result = QueryStringToListConverter::convert('year=2024&month=6');

        $this->assertInstanceOf(RequestParameterList::class, $result);
        $this->assertSame('2024', $result->get('year'));
        $this->assertSame('6', $result->get('month'));
    }

    public function testConvertEmptyQueryString(): void
    {
        $result = QueryStringToListConverter::convert('');

        $this->assertSame([], $result->getList());
    }

    public function testConvertQueryStringWithEncodedEntities(): void
    {
        $result = QueryStringToListConverter::convert('name=foo&amp;value=bar');

        $this->assertTrue($result->has('name'));
        $this->assertSame('foo', $result->get('name'));
        $this->assertTrue($result->has('value'));
        $this->assertSame('bar', $result->get('value'));
    }

    public function testConvertQueryStringWithSpecialCharacters(): void
    {
        $result = QueryStringToListConverter::convert('search=hello+world');

        $this->assertSame('hello world', $result->get('search'));
    }

    public function testConvertQueryStringWithUrlEncodedValues(): void
    {
        $result = QueryStringToListConverter::convert('city=M%C3%BCnchen');

        $this->assertSame('München', $result->get('city'));
    }

    public function testConvertQueryStringWithArrayParametersThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);

        QueryStringToListConverter::convert('tags[]=foo&tags[]=bar');
    }

    public function testConvertQueryStringWithMultipleParameters(): void
    {
        $result = QueryStringToListConverter::convert('orderBy=name&orderDirection=ASC&size=20&from=0');

        $this->assertSame('name', $result->get('orderBy'));
        $this->assertSame('ASC', $result->get('orderDirection'));
        $this->assertSame('20', $result->get('size'));
        $this->assertSame('0', $result->get('from'));
    }
}
