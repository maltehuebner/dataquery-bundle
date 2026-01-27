<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Parameter;

use MalteHuebner\DataQueryBundle\Parameter\OrderParameter;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Parameter\PropertyTargetingParameterInterface;
use MalteHuebner\DataQueryBundle\Parameter\StartValueParameter;
use PHPUnit\Framework\TestCase;

class StartValueParameterTest extends TestCase
{
    public function testImplementsParameterInterface(): void
    {
        $parameter = new StartValueParameter();

        $this->assertInstanceOf(ParameterInterface::class, $parameter);
    }

    public function testImplementsPropertyTargetingParameterInterface(): void
    {
        $parameter = new StartValueParameter();

        $this->assertInstanceOf(PropertyTargetingParameterInterface::class, $parameter);
    }

    public function testExtendsOrderParameter(): void
    {
        $parameter = new StartValueParameter();

        $this->assertInstanceOf(OrderParameter::class, $parameter);
    }

    public function testSetStartValue(): void
    {
        $parameter = new StartValueParameter();
        $result = $parameter->setStartValue('some-value');

        $this->assertSame($parameter, $result);
    }

    public function testSetStartValueWithInt(): void
    {
        $parameter = new StartValueParameter();
        $parameter->setStartValue(42);

        $this->assertTrue(true);
    }

    public function testSetStartValueWithString(): void
    {
        $parameter = new StartValueParameter();
        $parameter->setStartValue('abc');

        $this->assertTrue(true);
    }

    public function testInheritsSetPropertyName(): void
    {
        $parameter = new StartValueParameter();
        $parameter->setPropertyName('title');

        $this->assertSame('title', $parameter->getPropertyName());
    }

    public function testInheritsSetDirection(): void
    {
        $parameter = new StartValueParameter();
        $parameter->setDirection('ASC');

        $this->assertTrue(true);
    }
}
