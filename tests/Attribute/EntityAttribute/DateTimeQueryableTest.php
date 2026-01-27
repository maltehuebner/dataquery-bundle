<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\EntityAttribute;

use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\DateTimeQueryable;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\EntityAttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Queryable;
use PHPUnit\Framework\TestCase;

class DateTimeQueryableTest extends TestCase
{
    public function testExtendsQueryable(): void
    {
        $attr = new DateTimeQueryable();

        $this->assertInstanceOf(Queryable::class, $attr);
    }

    public function testImplementsEntityAttributeInterface(): void
    {
        $attr = new DateTimeQueryable();

        $this->assertInstanceOf(EntityAttributeInterface::class, $attr);
    }

    public function testGetFormat(): void
    {
        $attr = new DateTimeQueryable(format: 'yyyy-MM-dd');

        $this->assertSame('yyyy-MM-dd', $attr->getFormat());
    }

    public function testGetPattern(): void
    {
        $attr = new DateTimeQueryable(pattern: 'Y-m-d');

        $this->assertSame('Y-m-d', $attr->getPattern());
    }

    public function testGetAccepts(): void
    {
        $attr = new DateTimeQueryable(accepts: ['year', 'month', 'day']);

        $this->assertSame(['year', 'month', 'day'], $attr->getAccepts());
    }

    public function testDefaultValues(): void
    {
        $attr = new DateTimeQueryable();

        $this->assertSame([], $attr->getAccepts());
        $this->assertNull($attr->getFormat());
        $this->assertNull($attr->getPattern());
    }

    public function testAllParameters(): void
    {
        $attr = new DateTimeQueryable(
            accepts: ['year'],
            format: 'yyyy-MM-dd',
            pattern: 'Y-m-d'
        );

        $this->assertSame(['year'], $attr->getAccepts());
        $this->assertSame('yyyy-MM-dd', $attr->getFormat());
        $this->assertSame('Y-m-d', $attr->getPattern());
    }
}
