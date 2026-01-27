<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\RequestParameterList;

use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestToListConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RequestToListConverterTest extends TestCase
{
    public function testConvertSimpleRequest(): void
    {
        $request = Request::create('/test', 'GET', ['year' => '2024', 'month' => '6']);

        $result = RequestToListConverter::convert($request);

        $this->assertInstanceOf(RequestParameterList::class, $result);
        $this->assertSame('2024', $result->get('year'));
        $this->assertSame('6', $result->get('month'));
    }

    public function testConvertEmptyRequest(): void
    {
        $request = Request::create('/test');

        $result = RequestToListConverter::convert($request);

        $this->assertSame([], $result->getList());
    }

    public function testConvertRequestWithArrayQueryParameter(): void
    {
        $request = Request::create('/test', 'GET', ['tags' => ['foo', 'bar']]);

        $result = RequestToListConverter::convert($request);

        $this->assertSame('foo,bar', $result->get('tags'));
    }

    public function testConvertRequestWithIntegerQueryParameter(): void
    {
        $request = Request::create('/test', 'GET', ['size' => 25]);

        $result = RequestToListConverter::convert($request);

        $this->assertSame('25', $result->get('size'));
    }

    public function testConvertRequestWithMultipleParameters(): void
    {
        $request = Request::create('/test', 'GET', [
            'orderBy' => 'name',
            'orderDirection' => 'ASC',
            'size' => '20',
            'from' => '0',
        ]);

        $result = RequestToListConverter::convert($request);

        $this->assertSame('name', $result->get('orderBy'));
        $this->assertSame('ASC', $result->get('orderDirection'));
        $this->assertSame('20', $result->get('size'));
        $this->assertSame('0', $result->get('from'));
    }

    public function testConvertRequestWithQueryString(): void
    {
        $request = Request::create('/test?year=2024&month=1');

        $result = RequestToListConverter::convert($request);

        $this->assertSame('2024', $result->get('year'));
        $this->assertSame('1', $result->get('month'));
    }

    public function testConvertRequestIgnoresPostData(): void
    {
        $request = Request::create('/test', 'POST', [], [], [], [], 'postData=value');
        $request->query->set('queryParam', 'queryValue');

        $result = RequestToListConverter::convert($request);

        $this->assertTrue($result->has('queryParam'));
        $this->assertFalse($result->has('postData'));
    }
}
