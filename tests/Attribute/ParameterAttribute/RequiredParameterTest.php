<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\ParameterAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute\ParameterAttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute\RequiredParameter;
use PHPUnit\Framework\TestCase;

class RequiredParameterTest extends TestCase
{
    public function testImplementsAttributeInterface(): void
    {
        $attr = new RequiredParameter(parameterName: 'size');

        $this->assertInstanceOf(AttributeInterface::class, $attr);
    }

    public function testImplementsParameterAttributeInterface(): void
    {
        $attr = new RequiredParameter(parameterName: 'size');

        $this->assertInstanceOf(ParameterAttributeInterface::class, $attr);
    }

    public function testGetParameterName(): void
    {
        $attr = new RequiredParameter(parameterName: 'size');

        $this->assertSame('size', $attr->getParameterName());
    }

    public function testDifferentParameterNames(): void
    {
        $this->assertSame('orderBy', (new RequiredParameter(parameterName: 'orderBy'))->getParameterName());
        $this->assertSame('from', (new RequiredParameter(parameterName: 'from'))->getParameterName());
        $this->assertSame('orderDirection', (new RequiredParameter(parameterName: 'orderDirection'))->getParameterName());
    }
}
