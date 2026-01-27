<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Factory\QueryFactory;

use MalteHuebner\DataQueryBundle\Factory\QueryFactory\QueryFactory;
use MalteHuebner\DataQueryBundle\Factory\QueryFactory\QueryFactoryInterface;
use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueAssignerInterface;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldList;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldList;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Manager\QueryManagerInterface;
use MalteHuebner\DataQueryBundle\Query\BoundingBoxQuery;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QueryFactoryTest extends TestCase
{
    private QueryManagerInterface $queryManager;
    private ValueAssignerInterface $valueAssigner;
    private ValidatorInterface $validator;
    private EntityFieldListFactoryInterface $entityFieldListFactory;
    private QueryFieldListFactoryInterface $queryFieldListFactory;

    protected function setUp(): void
    {
        $this->queryManager = $this->createMock(QueryManagerInterface::class);
        $this->valueAssigner = $this->createMock(ValueAssignerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->entityFieldListFactory = $this->createMock(EntityFieldListFactoryInterface::class);
        $this->queryFieldListFactory = $this->createMock(QueryFieldListFactoryInterface::class);
    }

    private function createFactory(): QueryFactory
    {
        return new QueryFactory(
            $this->queryManager,
            $this->valueAssigner,
            $this->validator,
            $this->entityFieldListFactory,
            $this->queryFieldListFactory
        );
    }

    public function testImplementsInterface(): void
    {
        $factory = $this->createFactory();

        $this->assertInstanceOf(QueryFactoryInterface::class, $factory);
    }

    public function testSetEntityFqcnReturnsInterface(): void
    {
        $factory = $this->createFactory();

        $result = $factory->setEntityFqcn('App\\Entity\\Ride');

        $this->assertInstanceOf(QueryFactoryInterface::class, $result);
    }

    public function testCreateFromListReturnsEmptyArrayWhenNoQueriesMatch(): void
    {
        $this->queryManager->method('getQueryList')->willReturn([new BoundingBoxQuery()]);

        $this->queryFieldListFactory->method('createForFqcn')->willReturn(new QueryFieldList());
        $this->entityFieldListFactory->method('createForFqcn')->willReturn(new EntityFieldList());

        // Validation fails (returns violations = not valid)
        $violations = $this->createMock(ConstraintViolationList::class);
        $violations->method('count')->willReturn(1);
        $this->validator->method('validate')->willReturn($violations);

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertIsArray($result);
    }

    public function testCreateFromListReturnsQueriesWhenValid(): void
    {
        if (!class_exists('App\\Criticalmass\\Util\\ClassUtil')) {
            $this->markTestSkipped('ClassUtil is not available (external dependency).');
        }

        $boundingBoxQuery = new BoundingBoxQuery();
        $this->queryManager->method('getQueryList')->willReturn([$boundingBoxQuery]);

        $this->queryFieldListFactory->method('createForFqcn')->willReturn(new QueryFieldList());
        $this->entityFieldListFactory->method('createForFqcn')->willReturn(new EntityFieldList());

        // Validation passes
        $violations = $this->createMock(ConstraintViolationList::class);
        $violations->method('count')->willReturn(0);
        $this->validator->method('validate')->willReturn($violations);

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertNotEmpty($result);
    }

    public function testCreateFromListWithEmptyQueryManager(): void
    {
        $this->queryManager->method('getQueryList')->willReturn([]);
        $this->entityFieldListFactory->method('createForFqcn')->willReturn(new EntityFieldList());

        $factory = $this->createFactory();
        $factory->setEntityFqcn('App\\Entity\\Ride');

        $result = $factory->createFromList(new RequestParameterList());

        $this->assertIsArray($result);
    }
}
