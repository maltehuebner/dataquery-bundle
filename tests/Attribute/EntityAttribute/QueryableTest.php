<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\EntityAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\EntityAttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Queryable;
use PHPUnit\Framework\TestCase;

class QueryableTest extends TestCase
{
    public function testImplementsAttributeInterface(): void
    {
        $queryable = new Queryable();

        $this->assertInstanceOf(AttributeInterface::class, $queryable);
    }

    public function testImplementsEntityAttributeInterface(): void
    {
        $queryable = new Queryable();

        $this->assertInstanceOf(EntityAttributeInterface::class, $queryable);
    }

    public function testIsAttribute(): void
    {
        $reflectionClass = new \ReflectionClass(Queryable::class);
        $attributes = $reflectionClass->getAttributes(\Attribute::class);

        $this->assertCount(1, $attributes);
    }
}
