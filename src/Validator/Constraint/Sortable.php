<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Validator\Constraint;

use MalteHuebner\DataQueryBundle\Validator\SortableValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Sortable extends Constraint
{
    public $message = 'Target field {{ entityTargetPropertyName }} of class {{ entityFqcn }} ist not sortable';

    #[\Override]
    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    #[\Override]
    public function validatedBy(): string
    {
        return SortableValidator::class;
    }
}
