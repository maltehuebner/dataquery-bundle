<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Validator\Constraint;

use Maltehuebner\DataQueryBundle\Validator\BoundingBoxValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BoundingBoxValues extends Constraint
{
    public $message = 'Invalid values for Bounding Box Query.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return BoundingBoxValidator::class;
    }
}
