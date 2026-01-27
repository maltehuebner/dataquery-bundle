<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Exception;

use MalteHuebner\DataQueryBundle\Exception\DataQueryException;
use MalteHuebner\DataQueryBundle\Exception\NoTypedParameterForRequiredMethodException;
use PHPUnit\Framework\TestCase;

class NoTypedParameterForRequiredMethodExceptionTest extends TestCase
{
    public function testExtendsDataQueryException(): void
    {
        $exception = new NoTypedParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertInstanceOf(DataQueryException::class, $exception);
    }

    public function testMessageContainsMethodName(): void
    {
        $exception = new NoTypedParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertStringContainsString('setYear', $exception->getMessage());
    }

    public function testMessageContainsClassName(): void
    {
        $exception = new NoTypedParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertStringContainsString('App\\Query\\YearQuery', $exception->getMessage());
    }

    public function testMessageFormat(): void
    {
        $exception = new NoTypedParameterForRequiredMethodException('doSomething', 'My\\Class');

        $this->assertSame(
            'Method "doSomething" of class "My\\Class" has no typed parameter',
            $exception->getMessage()
        );
    }
}
