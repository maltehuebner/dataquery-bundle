<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\EntityFieldList;

use MalteHuebner\DataQueryBundle\Exception\NoReturnTypeForEntityMethodException;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldList;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldListFactory;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Tests\Fixtures\TestEntity;
use MalteHuebner\DataQueryBundle\Tests\Fixtures\TestEntityNoReturnType;
use PHPUnit\Framework\TestCase;

class EntityFieldListFactoryTest extends TestCase
{
    private EntityFieldListFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new EntityFieldListFactory();
    }

    public function testImplementsInterface(): void
    {
        $this->assertInstanceOf(EntityFieldListFactoryInterface::class, $this->factory);
    }

    public function testCreateForFqcnReturnsEntityFieldList(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $this->assertInstanceOf(EntityFieldList::class, $result);
    }

    public function testDetectsQueryableProperties(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $this->assertTrue($result->hasField('title'));
        $this->assertTrue($result->hasField('description'));
    }

    public function testDetectsSortableProperties(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $this->assertTrue($result->hasField('title'));
        $this->assertTrue($result->hasField('position'));
    }

    public function testDetectsDateTimeQueryableProperties(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $this->assertTrue($result->hasField('dateTime'));

        $dateTimeFields = $result->getList()['dateTime'];
        $found = false;
        foreach ($dateTimeFields as $field) {
            if ($field->getDateTimeFormat() !== null) {
                $this->assertSame('yyyy-MM-dd', $field->getDateTimeFormat());
                $this->assertSame('Y-m-d', $field->getDateTimePattern());
                $found = true;
            }
        }
        $this->assertTrue($found, 'DateTimeQueryable field not found');
    }

    public function testDetectsDefaultBooleanValueProperties(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $this->assertTrue($result->hasField('enabled'));

        $enabledFields = $result->getList()['enabled'];
        $found = false;
        foreach ($enabledFields as $field) {
            if ($field->hasDefaultQueryBool()) {
                $this->assertTrue($field->getDefaultQueryBoolValue());
                $found = true;
            }
        }
        $this->assertTrue($found, 'DefaultBooleanValue field not found');
    }

    public function testDetectsMethodAttributes(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $this->assertTrue($result->hasField('getTitle'));
    }

    public function testMethodFieldHasType(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $getTitleFields = $result->getList()['getTitle'];
        $this->assertNotEmpty($getTitleFields);

        $field = $getTitleFields[0];
        $this->assertSame('string', $field->getType());
        $this->assertSame('getTitle', $field->getMethodName());
    }

    public function testThrowsExceptionForMethodWithoutReturnType(): void
    {
        $this->expectException(NoReturnTypeForEntityMethodException::class);

        $this->factory->createForFqcn(TestEntityNoReturnType::class);
    }

    public function testTitlePropertyHasQueryableAndSortable(): void
    {
        $result = $this->factory->createForFqcn(TestEntity::class);

        $titleFields = $result->getList()['title'];

        $hasQueryable = false;
        $hasSortable = false;

        foreach ($titleFields as $field) {
            if ($field->isQueryable()) {
                $hasQueryable = true;
            }
            if ($field->isSortable()) {
                $hasSortable = true;
            }
        }

        $this->assertTrue($hasQueryable, 'Title should be queryable');
        $this->assertTrue($hasSortable, 'Title should be sortable');
    }
}
