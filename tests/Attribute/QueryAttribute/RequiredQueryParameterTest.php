<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Attribute\QueryAttribute;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute\QueryAttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute\RequiredQueryParameter;
use PHPUnit\Framework\TestCase;

class RequiredQueryParameterTest extends TestCase
{
    public function testImplementsAttributeInterface(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'year');

        $this->assertInstanceOf(AttributeInterface::class, $attr);
    }

    public function testImplementsQueryAttributeInterface(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'year');

        $this->assertInstanceOf(QueryAttributeInterface::class, $attr);
    }

    public function testGetParameterName(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'year');

        $this->assertSame('year', $attr->getParameterName());
    }

    public function testGetRepositoryDefaultNull(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'year');

        $this->assertNull($attr->getRepository());
    }

    public function testGetRepository(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'city', repository: 'App\\Repository\\CityRepository');

        $this->assertSame('App\\Repository\\CityRepository', $attr->getRepository());
    }

    public function testGetRepositoryMethodDefaultNull(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'year');

        $this->assertNull($attr->getRepositoryMethod());
    }

    public function testGetRepositoryMethod(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'city', repositoryMethod: 'findBySlug');

        $this->assertSame('findBySlug', $attr->getRepositoryMethod());
    }

    public function testGetAccessorDefaultNull(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'year');

        $this->assertNull($attr->getAccessor());
    }

    public function testGetAccessor(): void
    {
        $attr = new RequiredQueryParameter(parameterName: 'city', accessor: 'getId');

        $this->assertSame('getId', $attr->getAccessor());
    }

    public function testAllParameters(): void
    {
        $attr = new RequiredQueryParameter(
            parameterName: 'citySlug',
            repository: 'App\\Repository\\CityRepository',
            repositoryMethod: 'findBySlug',
            accessor: 'getId'
        );

        $this->assertSame('citySlug', $attr->getParameterName());
        $this->assertSame('App\\Repository\\CityRepository', $attr->getRepository());
        $this->assertSame('findBySlug', $attr->getRepositoryMethod());
        $this->assertSame('getId', $attr->getAccessor());
    }
}
