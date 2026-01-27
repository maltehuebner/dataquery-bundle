<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Validator;

use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityField;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldList;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Parameter\OrderParameter;
use MalteHuebner\DataQueryBundle\Validator\Constraint\Sortable;
use MalteHuebner\DataQueryBundle\Validator\SortableValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class SortableValidatorTest extends TestCase
{
    private SortableValidator $validator;
    private EntityFieldListFactoryInterface $entityFieldListFactory;
    private ExecutionContextInterface $context;
    private ConstraintViolationBuilderInterface $violationBuilder;

    protected function setUp(): void
    {
        $this->entityFieldListFactory = $this->createMock(EntityFieldListFactoryInterface::class);
        $this->validator = new SortableValidator($this->entityFieldListFactory);

        $this->violationBuilder = $this->createMock(ConstraintViolationBuilderInterface::class);
        $this->violationBuilder->method('setParameter')->willReturnSelf();

        $this->context = $this->createMock(ExecutionContextInterface::class);
        $this->context->method('buildViolation')->willReturn($this->violationBuilder);

        $this->validator->initialize($this->context);
    }

    public function testValidSortableProperty(): void
    {
        $entityFieldList = new EntityFieldList();
        $field = new EntityField();
        $field->setSortable(true);
        $entityFieldList->addField('name', $field);

        $parameter = new OrderParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $this->entityFieldListFactory
            ->method('createForFqcn')
            ->with('App\\Entity\\Test')
            ->willReturn($entityFieldList);

        $this->context
            ->method('getRoot')
            ->willReturn($parameter);

        $this->context->expects($this->never())->method('buildViolation');

        $constraint = new Sortable();
        $this->validator->validate('name', $constraint);
    }

    public function testNonSortablePropertyAddsViolation(): void
    {
        $entityFieldList = new EntityFieldList();
        $field = new EntityField();
        $field->setSortable(false);
        $entityFieldList->addField('description', $field);

        $parameter = new OrderParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $this->entityFieldListFactory
            ->method('createForFqcn')
            ->willReturn($entityFieldList);

        $this->context
            ->method('getRoot')
            ->willReturn($parameter);

        $this->context->expects($this->atLeastOnce())->method('buildViolation');

        $constraint = new Sortable();
        $this->validator->validate('description', $constraint);
    }

    public function testNonExistingPropertyAddsViolation(): void
    {
        $entityFieldList = new EntityFieldList();

        $parameter = new OrderParameter();
        $parameter->setEntityFqcn('App\\Entity\\Test');

        $this->entityFieldListFactory
            ->method('createForFqcn')
            ->willReturn($entityFieldList);

        $this->context
            ->method('getRoot')
            ->willReturn($parameter);

        $this->context->expects($this->atLeastOnce())->method('buildViolation');

        $constraint = new Sortable();
        $this->validator->validate('nonexistent', $constraint);
    }

    public function testEmptyValueSkipsValidation(): void
    {
        $this->context->expects($this->never())->method('buildViolation');

        $constraint = new Sortable();
        $this->validator->validate('', $constraint);
    }

    public function testNullValueSkipsValidation(): void
    {
        $this->context->expects($this->never())->method('buildViolation');

        $constraint = new Sortable();
        $this->validator->validate(null, $constraint);
    }
}
