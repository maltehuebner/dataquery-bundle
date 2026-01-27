<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Exception;

use MalteHuebner\DataQueryBundle\Exception\DataQueryException;
use MalteHuebner\DataQueryBundle\Exception\NotOneParameterForRequiredMethodException;
use PHPUnit\Framework\TestCase;

class NotOneParameterForRequiredMethodExceptionTest extends TestCase
{
    public function testExtendsDataQueryException(): void
    {
        $exception = new NotOneParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertInstanceOf(DataQueryException::class, $exception);
    }

    public function testExtendsBaseException(): void
    {
        $exception = new NotOneParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testMessageContainsMethodName(): void
    {
        $exception = new NotOneParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertStringContainsString('setYear', $exception->getMessage());
    }

    public function testMessageContainsClassName(): void
    {
        $exception = new NotOneParameterForRequiredMethodException('setYear', 'App\\Query\\YearQuery');

        $this->assertStringContainsString('App\\Query\\YearQuery', $exception->getMessage());
    }

    public function testMessageFormat(): void
    {
        $exception = new NotOneParameterForRequiredMethodException('doSomething', 'My\\Class');

        $this->assertSame(
            'Method "doSomething" of class "My\\Class" has no or more than one parameters',
            $exception->getMessage()
        );
    }
}
