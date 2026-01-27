<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Validator\Constraint;

use MalteHuebner\DataQueryBundle\Validator\BoundingBoxValidator;
use MalteHuebner\DataQueryBundle\Validator\Constraint\BoundingBoxValues;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;

class BoundingBoxValuesTest extends TestCase
{
    public function testExtendsConstraint(): void
    {
        $constraint = new BoundingBoxValues();

        $this->assertInstanceOf(Constraint::class, $constraint);
    }

    public function testGetTargetsReturnsClassConstraint(): void
    {
        $constraint = new BoundingBoxValues();

        $this->assertSame(Constraint::CLASS_CONSTRAINT, $constraint->getTargets());
    }

    public function testValidatedByReturnsBoundingBoxValidatorClass(): void
    {
        $constraint = new BoundingBoxValues();

        $this->assertSame(BoundingBoxValidator::class, $constraint->validatedBy());
    }

    public function testHasDefaultMessage(): void
    {
        $constraint = new BoundingBoxValues();

        $this->assertSame('Invalid values for Bounding Box Query.', $constraint->message);
    }
}
