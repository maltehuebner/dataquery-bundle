<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\EntityAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\EntityAttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Sortable;
use PHPUnit\Framework\TestCase;

class SortableTest extends TestCase
{
    public function testImplementsAttributeInterface(): void
    {
        $sortable = new Sortable();

        $this->assertInstanceOf(AttributeInterface::class, $sortable);
    }

    public function testImplementsEntityAttributeInterface(): void
    {
        $sortable = new Sortable();

        $this->assertInstanceOf(EntityAttributeInterface::class, $sortable);
    }

    public function testIsAttribute(): void
    {
        $reflectionClass = new \ReflectionClass(Sortable::class);
        $attributes = $reflectionClass->getAttributes(\Attribute::class);

        $this->assertCount(1, $attributes);
    }
}
