<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Manager;

use MalteHuebner\DataQueryBundle\Manager\ParameterManager;
use MalteHuebner\DataQueryBundle\Manager\ParameterManagerInterface;
use MalteHuebner\DataQueryBundle\Parameter\FromParameter;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use PHPUnit\Framework\TestCase;

class ParameterManagerTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $manager = new ParameterManager();

        $this->assertInstanceOf(ParameterManagerInterface::class, $manager);
    }

    public function testGetParameterListReturnsEmptyArrayInitially(): void
    {
        $manager = new ParameterManager();

        $this->assertSame([], $manager->getParameterList());
    }

    public function testAddParameter(): void
    {
        $manager = new ParameterManager();
        $parameter = new SizeParameter();

        $result = $manager->addParameter($parameter);

        $this->assertInstanceOf(ParameterManagerInterface::class, $result);
        $this->assertCount(1, $manager->getParameterList());
        $this->assertSame($parameter, $manager->getParameterList()[0]);
    }

    public function testAddMultipleParameters(): void
    {
        $manager = new ParameterManager();
        $param1 = new SizeParameter();
        $param2 = new FromParameter();

        $manager->addParameter($param1);
        $manager->addParameter($param2);

        $this->assertCount(2, $manager->getParameterList());
        $this->assertSame($param1, $manager->getParameterList()[0]);
        $this->assertSame($param2, $manager->getParameterList()[1]);
    }

    public function testFluentInterface(): void
    {
        $manager = new ParameterManager();
        $param1 = new SizeParameter();
        $param2 = new FromParameter();

        $result = $manager
            ->addParameter($param1)
            ->addParameter($param2);

        $this->assertInstanceOf(ParameterManagerInterface::class, $result);
        $this->assertCount(2, $manager->getParameterList());
    }
}
