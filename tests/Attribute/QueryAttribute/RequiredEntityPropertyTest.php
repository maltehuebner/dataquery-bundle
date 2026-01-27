<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute\QueryAttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute\RequiredEntityProperty;
use PHPUnit\Framework\TestCase;

class RequiredEntityPropertyTest extends TestCase
{
    public function testImplementsAttributeInterface(): void
    {
        $attr = new RequiredEntityProperty(propertyName: 'pin');

        $this->assertInstanceOf(AttributeInterface::class, $attr);
    }

    public function testImplementsQueryAttributeInterface(): void
    {
        $attr = new RequiredEntityProperty(propertyName: 'pin');

        $this->assertInstanceOf(QueryAttributeInterface::class, $attr);
    }

    public function testGetPropertyName(): void
    {
        $attr = new RequiredEntityProperty(propertyName: 'dateTime');

        $this->assertSame('dateTime', $attr->getPropertyName());
    }

    public function testGetPropertyTypeDefaultNull(): void
    {
        $attr = new RequiredEntityProperty(propertyName: 'pin');

        $this->assertNull($attr->getPropertyType());
    }

    public function testGetPropertyType(): void
    {
        $attr = new RequiredEntityProperty(propertyName: 'pin', propertyType: 'string');

        $this->assertSame('string', $attr->getPropertyType());
    }

    public function testAllParameters(): void
    {
        $attr = new RequiredEntityProperty(propertyName: 'dateTime', propertyType: 'DateTime');

        $this->assertSame('dateTime', $attr->getPropertyName());
        $this->assertSame('DateTime', $attr->getPropertyType());
    }
}
