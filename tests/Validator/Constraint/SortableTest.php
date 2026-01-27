<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Validator\Constraint;

use MalteHuebner\DataQueryBundle\Validator\Constraint\Sortable;
use MalteHuebner\DataQueryBundle\Validator\SortableValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;

class SortableTest extends TestCase
{
    public function testExtendsConstraint(): void
    {
        $constraint = new Sortable();

        $this->assertInstanceOf(Constraint::class, $constraint);
    }

    public function testGetTargetsReturnsPropertyConstraint(): void
    {
        $constraint = new Sortable();

        $this->assertSame(Constraint::PROPERTY_CONSTRAINT, $constraint->getTargets());
    }

    public function testValidatedByReturnsSortableValidatorClass(): void
    {
        $constraint = new Sortable();

        $this->assertSame(SortableValidator::class, $constraint->validatedBy());
    }

    public function testHasDefaultMessage(): void
    {
        $constraint = new Sortable();

        $this->assertStringContainsString('not sortable', $constraint->message);
    }

    public function testMessageContainsPlaceholders(): void
    {
        $constraint = new Sortable();

        $this->assertStringContainsString('{{ entityTargetPropertyName }}', $constraint->message);
        $this->assertStringContainsString('{{ entityFqcn }}', $constraint->message);
    }
}
