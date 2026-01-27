<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Parameter;

use MalteHuebner\DataQueryBundle\Parameter\AbstractParameter;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use PHPUnit\Framework\TestCase;

class SizeParameterTest extends TestCase
{
    public function testImplementsParameterInterface(): void
    {
        $parameter = new SizeParameter();

        $this->assertInstanceOf(ParameterInterface::class, $parameter);
    }

    public function testExtendsAbstractParameter(): void
    {
        $parameter = new SizeParameter();

        $this->assertInstanceOf(AbstractParameter::class, $parameter);
    }

    public function testSetSize(): void
    {
        $parameter = new SizeParameter();
        $result = $parameter->setSize(25);

        $this->assertSame($parameter, $result);
    }

    public function testSetEntityFqcn(): void
    {
        $parameter = new SizeParameter();
        $result = $parameter->setEntityFqcn('App\\Entity\\Ride');

        $this->assertSame('App\\Entity\\Ride', $parameter->getEntityFqcn());
        $this->assertSame($parameter, $result);
    }

    public function testAddToElasticQuery(): void
    {
        $parameter = new SizeParameter();
        $parameter->setSize(50);

        $elasticQuery = new \Elastica\Query();
        $result = $parameter->addToElasticQuery($elasticQuery);

        $this->assertInstanceOf(\Elastica\Query::class, $result);
    }
}
