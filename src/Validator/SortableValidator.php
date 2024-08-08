<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Validator;

use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityField;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldList;
use MalteHuebner\DataQueryBundle\FieldList\EntityFieldList\EntityFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SortableValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityFieldListFactoryInterface $entityFieldListFactory
    )
    {

    }

    #[\Override]
    public function validate($entityTargetPropertyName, Constraint $constraint): void
    {
        if (!$entityTargetPropertyName) {
            return;
        }
        
        /** @var ParameterInterface $parameter */
        $parameter = $this->context->getRoot();

        /** @var EntityFieldList $fieldList */
        $entityFieldList = $this->entityFieldListFactory->createForFqcn($parameter->getEntityFqcn());

        if (!$entityFieldList->hasField($entityTargetPropertyName)) {
            $this->buildViolation($entityTargetPropertyName, $constraint, $parameter);

            return;
        }

        $entityTargetPropertySortable = false;

        /** @var EntityField $entityField */
        foreach ($entityFieldList->getList()[$entityTargetPropertyName] as $entityField) {
            if ($entityField->isSortable()) {
                $entityTargetPropertySortable = true;

                break;
            }
        }

        if (!$entityTargetPropertySortable) {
            $this->buildViolation($entityTargetPropertyName, $constraint, $parameter);
        }
    }

    protected function buildViolation($entityTargetPropertyName, Constraint $constraint, ParameterInterface $parameter): void
    {
        $this
            ->context->buildViolation($constraint->message)
            ->setParameter('{{ entityTargetPropertyName }}', $entityTargetPropertyName)
            ->setParameter('{{ entityFqcn }}', $parameter->getEntityFqcn())
            ->addViolation();
    }
}
