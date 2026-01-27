<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Factory\ParameterFactory;

use MalteHuebner\DataQueryBundle\Factory\ParameterFactory\ParameterFactory;
use MalteHuebner\DataQueryBundle\Factory\ParameterFactory\ParameterFactoryInterface;
use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueAssignerInterface;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldList;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Manager\ParameterManagerInterface;
use MalteHuebner\DataQueryBundle\Parameter\SizeParameter;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParameterFactoryTest extends TestCase
{
    private ParameterManagerInterface $parameterManager;
    private ValueAssignerInterface $valueAssigner;
    private ValidatorInterface $validator;
    private ParameterFieldListFactoryInterface $parameterFieldListFactory;

    protected function setUp(): void
    {
        $this->parameterManager = $this->createMock(ParameterManagerInterface::class);
        $this->valueAssigner = $this->createMock(ValueAssignerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->parameterFieldListFactory = $this->createMock(ParameterFieldListFactoryInterface::class);
    }

    private function createFactory(): ParameterFactory
    {
        return new ParameterFactory(
            $this->parameterManager,
            $this->valueAssigner,
            $this->validator,
            $this->parameterFieldListFactory
        );
    }

    public function testImplementsInterface(): void
    {
        $factory = $this->createFactory();

        $this->assertInstanceOf(ParameterFactoryInterface::class, $factory);
    }

    public function testSetEntityFqcnReturnsInterface(): void
    {
        $factory = $this->createFactory();

        $result = $factory->setEntityFqcn('App\\Entity\\Ride');

        $this->assertInstanceOf(ParameterFactoryInterface::class, $result);
    }

    public function testCreateFromListReturnsEmptyArrayWhenNoParametersMatch(): void
    {
        $sizeParameter = new SizeParameter();
        $this->parameterManager->method('getParameterList')->willReturn([$sizeParameter]);
        $this->parameterFieldListFactory->method('createForFqcn')->willReturn(new ParameterFieldList());

        // Validation fails
        $violations = $this->createMock(ConstraintViolationList::class);
        $violations->method('count')->willReturn(1);
        $this->validator->method('validate')->willReturn($violations);

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertSame([], $result);
    }

    public function testCreateFromListReturnsParametersWhenValid(): void
    {
        $sizeParameter = new SizeParameter();
        $this->parameterManager->method('getParameterList')->willReturn([$sizeParameter]);
        $this->parameterFieldListFactory->method('createForFqcn')->willReturn(new ParameterFieldList());

        // Validation passes
        $violations = $this->createMock(ConstraintViolationList::class);
        $violations->method('count')->willReturn(0);
        $this->validator->method('validate')->willReturn($violations);

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertCount(1, $result);
        $this->assertInstanceOf(SizeParameter::class, $result[0]);
    }

    public function testCreateFromListWithEmptyParameterManager(): void
    {
        $this->parameterManager->method('getParameterList')->willReturn([]);

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertSame([], $result);
    }

    public function testCreateFromListSetsEntityFqcnOnParameter(): void
    {
        $sizeParameter = new SizeParameter();
        $this->parameterManager->method('getParameterList')->willReturn([$sizeParameter]);
        $this->parameterFieldListFactory->method('createForFqcn')->willReturn(new ParameterFieldList());

        $violations = $this->createMock(ConstraintViolationList::class);
        $violations->method('count')->willReturn(0);
        $this->validator->method('validate')->willReturn($violations);

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertSame('App\\Entity\\Ride', $result[0]->getEntityFqcn());
    }
}
