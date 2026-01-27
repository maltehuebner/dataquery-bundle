<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Parameter;

use MalteHuebner\DataQueryBundle\Parameter\AbstractParameter;
use MalteHuebner\DataQueryBundle\Parameter\FromParameter;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use PHPUnit\Framework\TestCase;

class FromParameterTest extends TestCase
{
    public function testImplementsParameterInterface(): void
    {
        $parameter = new FromParameter();

        $this->assertInstanceOf(ParameterInterface::class, $parameter);
    }

    public function testExtendsAbstractParameter(): void
    {
        $parameter = new FromParameter();

        $this->assertInstanceOf(AbstractParameter::class, $parameter);
    }

    public function testSetFrom(): void
    {
        $parameter = new FromParameter();
        $result = $parameter->setFrom(10);

        $this->assertSame($parameter, $result);
    }

    public function testSetEntityFqcn(): void
    {
        $parameter = new FromParameter();
        $parameter->setEntityFqcn('App\\Entity\\Ride');

        $this->assertSame('App\\Entity\\Ride', $parameter->getEntityFqcn());
    }

    public function testAddToElasticQuery(): void
    {
        $parameter = new FromParameter();
        $parameter->setFrom(20);

        $elasticQuery = new \Elastica\Query();
        $result = $parameter->addToElasticQuery($elasticQuery);

        $this->assertInstanceOf(\Elastica\Query::class, $result);
    }

    public function testSetFromZero(): void
    {
        $parameter = new FromParameter();
        $parameter->setFrom(0);

        $elasticQuery = new \Elastica\Query();
        $result = $parameter->addToElasticQuery($elasticQuery);

        $this->assertInstanceOf(\Elastica\Query::class, $result);
    }
}
