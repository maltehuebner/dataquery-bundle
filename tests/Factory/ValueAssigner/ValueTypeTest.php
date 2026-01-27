<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Factory\ValueAssigner;

use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueType;
use PHPUnit\Framework\TestCase;

class ValueTypeTest extends TestCase
{
    public function testStringConstant(): void
    {
        $this->assertSame('string', ValueType::STRING);
    }

    public function testIntConstant(): void
    {
        $this->assertSame('int', ValueType::INT);
    }

    public function testFloatConstant(): void
    {
        $this->assertSame('float', ValueType::FLOAT);
    }

    public function testBooleanConstant(): void
    {
        $this->assertSame('boolean', ValueType::BOOLEAN);
    }

    public function testArrayConstant(): void
    {
        $this->assertSame('array', ValueType::ARRAY);
    }

    public function testObjectConstant(): void
    {
        $this->assertSame('object', ValueType::OBJECT);
    }

    public function testNullConstant(): void
    {
        $this->assertSame('null', ValueType::NULL);
    }

    public function testMixedConstant(): void
    {
        $this->assertSame('mixed', ValueType::MIXED);
    }

    public function testCannotInstantiate(): void
    {
        $reflection = new \ReflectionClass(ValueType::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);
        $this->assertTrue($constructor->isPrivate());
    }
}
