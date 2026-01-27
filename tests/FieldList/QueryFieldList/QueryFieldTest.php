<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\FieldList\QueryFieldList;

use MalteHuebner\DataQueryBundle\FieldList\AbstractField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use PHPUnit\Framework\TestCase;

class QueryFieldTest extends TestCase
{
    public function testExtendsAbstractField(): void
    {
        $field = new QueryField();

        $this->assertInstanceOf(AbstractField::class, $field);
    }

    public function testParameterNameDefaultsNull(): void
    {
        $field = new QueryField();

        $this->assertNull($field->getParameterName());
    }

    public function testSetAndGetParameterName(): void
    {
        $field = new QueryField();
        $result = $field->setParameterName('year');

        $this->assertSame('year', $field->getParameterName());
        $this->assertSame($field, $result);
    }

    public function testRepositoryDefaultsNull(): void
    {
        $field = new QueryField();

        $this->assertNull($field->getRepository());
    }

    public function testSetAndGetRepository(): void
    {
        $field = new QueryField();
        $result = $field->setRepository('App\\Repository\\CityRepository');

        $this->assertSame('App\\Repository\\CityRepository', $field->getRepository());
        $this->assertSame($field, $result);
    }

    public function testSetRepositoryNull(): void
    {
        $field = new QueryField();
        $field->setRepository(null);

        $this->assertNull($field->getRepository());
    }

    public function testRepositoryMethodDefaultsNull(): void
    {
        $field = new QueryField();

        $this->assertNull($field->getRepositoryMethod());
    }

    public function testSetAndGetRepositoryMethod(): void
    {
        $field = new QueryField();
        $result = $field->setRepositoryMethod('findBySlug');

        $this->assertSame('findBySlug', $field->getRepositoryMethod());
        $this->assertSame($field, $result);
    }

    public function testAccessorDefaultsNull(): void
    {
        $field = new QueryField();

        $this->assertNull($field->getAccessor());
    }

    public function testSetAndGetAccessor(): void
    {
        $field = new QueryField();
        $result = $field->setAccessor('getId');

        $this->assertSame('getId', $field->getAccessor());
        $this->assertSame($field, $result);
    }

    public function testInheritedMethods(): void
    {
        $field = new QueryField();
        $field->setType('int');
        $field->setPropertyName('year');
        $field->setMethodName('setYear');

        $this->assertSame('int', $field->getType());
        $this->assertSame('year', $field->getPropertyName());
        $this->assertSame('setYear', $field->getMethodName());
    }

    public function testFullConfiguration(): void
    {
        $field = new QueryField();
        $field
            ->setParameterName('citySlug')
            ->setRepository('App\\Repository\\CityRepository')
            ->setRepositoryMethod('findBySlug')
            ->setAccessor('getId')
            ->setType('App\\Entity\\City')
            ->setMethodName('setCity');

        $this->assertSame('citySlug', $field->getParameterName());
        $this->assertSame('App\\Repository\\CityRepository', $field->getRepository());
        $this->assertSame('findBySlug', $field->getRepositoryMethod());
        $this->assertSame('getId', $field->getAccessor());
        $this->assertSame('App\\Entity\\City', $field->getType());
        $this->assertSame('setCity', $field->getMethodName());
    }
}
