<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Validator\Constraint;

use MalteHuebner\DataQueryBundle\Validator\BoundingBoxValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BoundingBoxValues extends Constraint
{
    public $message = 'Invalid values for Bounding Box Query.';

    #[\Override]
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    #[\Override]
    public function validatedBy(): string
    {
        return BoundingBoxValidator::class;
    }
}
