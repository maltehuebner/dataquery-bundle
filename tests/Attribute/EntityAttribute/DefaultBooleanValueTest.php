<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\EntityAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\DefaultBooleanValue;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\EntityAttributeInterface;
use PHPUnit\Framework\TestCase;

class DefaultBooleanValueTest extends TestCase
{
    public function testImplementsAttributeInterface(): void
    {
        $attr = new DefaultBooleanValue();

        $this->assertInstanceOf(AttributeInterface::class, $attr);
    }

    public function testImplementsEntityAttributeInterface(): void
    {
        $attr = new DefaultBooleanValue();

        $this->assertInstanceOf(EntityAttributeInterface::class, $attr);
    }

    public function testDefaultValues(): void
    {
        $attr = new DefaultBooleanValue();

        $this->assertNull($attr->getAlias());
        $this->assertFalse($attr->getValue());
    }

    public function testGetAlias(): void
    {
        $attr = new DefaultBooleanValue(alias: 'myAlias');

        $this->assertSame('myAlias', $attr->getAlias());
    }

    public function testGetValueTrue(): void
    {
        $attr = new DefaultBooleanValue(value: true);

        $this->assertTrue($attr->getValue());
    }

    public function testGetValueFalse(): void
    {
        $attr = new DefaultBooleanValue(value: false);

        $this->assertFalse($attr->getValue());
    }

    public function testAllParameters(): void
    {
        $attr = new DefaultBooleanValue(alias: 'isActive', value: true);

        $this->assertSame('isActive', $attr->getAlias());
        $this->assertTrue($attr->getValue());
    }
}
