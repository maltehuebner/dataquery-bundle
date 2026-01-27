<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Parameter;

use MalteHuebner\DataQueryBundle\Parameter\AbstractParameter;
use MalteHuebner\DataQueryBundle\Parameter\OrderDistanceParameter;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use PHPUnit\Framework\TestCase;

class OrderDistanceParameterTest extends TestCase
{
    public function testImplementsParameterInterface(): void
    {
        $parameter = new OrderDistanceParameter();

        $this->assertInstanceOf(ParameterInterface::class, $parameter);
    }

    public function testExtendsAbstractParameter(): void
    {
        $parameter = new OrderDistanceParameter();

        $this->assertInstanceOf(AbstractParameter::class, $parameter);
    }

    public function testSetLatitude(): void
    {
        $parameter = new OrderDistanceParameter();
        $result = $parameter->setLatitude(52.52);

        $this->assertSame($parameter, $result);
    }

    public function testSetLongitude(): void
    {
        $parameter = new OrderDistanceParameter();
        $result = $parameter->setLongitude(13.405);

        $this->assertSame($parameter, $result);
    }

    public function testSetDirectionUppercases(): void
    {
        $parameter = new OrderDistanceParameter();
        $result = $parameter->setDirection('asc');

        $this->assertSame($parameter, $result);
    }

    public function testSetEntityFqcn(): void
    {
        $parameter = new OrderDistanceParameter();
        $parameter->setEntityFqcn('App\\Entity\\Location');

        $this->assertSame('App\\Entity\\Location', $parameter->getEntityFqcn());
    }

    public function testAddToElasticQuery(): void
    {
        $parameter = new OrderDistanceParameter();
        $parameter->setLatitude(52.52);
        $parameter->setLongitude(13.405);
        $parameter->setDirection('ASC');

        $elasticQuery = new \Elastica\Query();
        $result = $parameter->addToElasticQuery($elasticQuery);

        $this->assertInstanceOf(\Elastica\Query::class, $result);
    }

    public function testNegativeCoordinates(): void
    {
        $parameter = new OrderDistanceParameter();
        $parameter->setLatitude(-33.87);
        $parameter->setLongitude(-151.21);
        $parameter->setDirection('DESC');

        $elasticQuery = new \Elastica\Query();
        $result = $parameter->addToElasticQuery($elasticQuery);

        $this->assertInstanceOf(\Elastica\Query::class, $result);
    }
}
