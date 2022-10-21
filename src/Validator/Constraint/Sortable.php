<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Validator\Constraint;

use Maltehuebner\DataQueryBundle\Validator\SortableValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Sortable extends Constraint
{
    public $message = 'Target field {{ entityTargetPropertyName }} of class {{ entityFqcn }} ist not sortable';

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return SortableValidator::class;
    }
}
