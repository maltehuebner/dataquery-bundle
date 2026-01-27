<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Exception;

use MalteHuebner\DataQueryBundle\Exception\DataQueryException;
use MalteHuebner\DataQueryBundle\Exception\NoReturnTypeForEntityMethodException;
use PHPUnit\Framework\TestCase;

class NoReturnTypeForEntityMethodExceptionTest extends TestCase
{
    public function testExtendsDataQueryException(): void
    {
        $exception = new NoReturnTypeForEntityMethodException('getTitle', 'App\\Entity\\Ride');

        $this->assertInstanceOf(DataQueryException::class, $exception);
    }

    public function testMessageContainsMethodName(): void
    {
        $exception = new NoReturnTypeForEntityMethodException('getTitle', 'App\\Entity\\Ride');

        $this->assertStringContainsString('getTitle', $exception->getMessage());
    }

    public function testMessageContainsClassName(): void
    {
        $exception = new NoReturnTypeForEntityMethodException('getTitle', 'App\\Entity\\Ride');

        $this->assertStringContainsString('App\\Entity\\Ride', $exception->getMessage());
    }

    public function testMessageFormat(): void
    {
        $exception = new NoReturnTypeForEntityMethodException('doSomething', 'My\\Class');

        $this->assertSame(
            'Method "doSomething" of class "My\\Class" has no return type',
            $exception->getMessage()
        );
    }
}
