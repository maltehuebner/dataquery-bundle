<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Parameter;

use MalteHuebner\DataQueryBundle\Parameter\AbstractParameter;
use MalteHuebner\DataQueryBundle\Parameter\OrderParameter;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Parameter\PropertyTargetingParameterInterface;
use PHPUnit\Framework\TestCase;

class OrderParameterTest extends TestCase
{
    public function testImplementsParameterInterface(): void
    {
        $parameter = new OrderParameter();

        $this->assertInstanceOf(ParameterInterface::class, $parameter);
    }

    public function testImplementsPropertyTargetingParameterInterface(): void
    {
        $parameter = new OrderParameter();

        $this->assertInstanceOf(PropertyTargetingParameterInterface::class, $parameter);
    }

    public function testExtendsAbstractParameter(): void
    {
        $parameter = new OrderParameter();

        $this->assertInstanceOf(AbstractParameter::class, $parameter);
    }

    public function testSetAndGetPropertyName(): void
    {
        $parameter = new OrderParameter();
        $result = $parameter->setPropertyName('title');

        $this->assertSame('title', $parameter->getPropertyName());
        $this->assertSame($parameter, $result);
    }

    public function testSetDirectionUppercases(): void
    {
        $parameter = new OrderParameter();
        $result = $parameter->setDirection('asc');

        $this->assertSame($parameter, $result);
    }

    public function testSetDirectionAlreadyUppercase(): void
    {
        $parameter = new OrderParameter();
        $parameter->setDirection('DESC');

        // no exception = OK
        $this->assertTrue(true);
    }

    public function testSetEntityFqcn(): void
    {
        $parameter = new OrderParameter();
        $parameter->setEntityFqcn('App\\Entity\\Ride');

        $this->assertSame('App\\Entity\\Ride', $parameter->getEntityFqcn());
    }

    public function testAddToElasticQuery(): void
    {
        $parameter = new OrderParameter();
        $parameter->setPropertyName('title');
        $parameter->setDirection('ASC');

        $elasticQuery = new \Elastica\Query();
        $result = $parameter->addToElasticQuery($elasticQuery);

        $this->assertInstanceOf(\Elastica\Query::class, $result);
    }
}
