<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Tests\Validator;

use MalteHuebner\DataQueryBundle\Query\BoundingBoxQuery;
use MalteHuebner\DataQueryBundle\Validator\BoundingBoxValidator;
use MalteHuebner\DataQueryBundle\Validator\Constraint\BoundingBoxValues;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class BoundingBoxValidatorTest extends TestCase
{
    private BoundingBoxValidator $validator;
    private ExecutionContextInterface $context;
    private ConstraintViolationBuilderInterface $violationBuilder;

    protected function setUp(): void
    {
        $this->validator = new BoundingBoxValidator();

        $this->violationBuilder = $this->createMock(ConstraintViolationBuilderInterface::class);

        $this->context = $this->createMock(ExecutionContextInterface::class);
        $this->context->method('buildViolation')->willReturn($this->violationBuilder);

        $this->validator->initialize($this->context);
    }

    public function testValidBoundingBox(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setSouthLatitude(52.50);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(9.5);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testInvalidNorthSouthLatitude(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(50.0);  // south > north
        $query->setSouthLatitude(53.0);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(9.5);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->atLeastOnce())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testInvalidWestEastLongitude(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setSouthLatitude(52.50);
        $query->setEastLongitude(9.0);   // west > east
        $query->setWestLongitude(10.0);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->atLeastOnce())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testEqualNorthSouthAddsViolation(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(52.0);
        $query->setSouthLatitude(52.0);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(9.5);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->atLeastOnce())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testEqualWestEastAddsViolation(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setSouthLatitude(52.50);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(10.0);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->atLeastOnce())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testMissingNorthLatitudeSkipsValidation(): void
    {
        $query = new BoundingBoxQuery();
        $query->setSouthLatitude(52.50);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(9.5);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testMissingSouthLatitudeSkipsValidation(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setEastLongitude(10.0);
        $query->setWestLongitude(9.5);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testMissingEastLongitudeSkipsValidation(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setSouthLatitude(52.50);
        $query->setWestLongitude(9.5);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testMissingWestLongitudeSkipsValidation(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(53.55);
        $query->setSouthLatitude(52.50);
        $query->setEastLongitude(10.0);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }

    public function testNegativeCoordinatesValid(): void
    {
        $query = new BoundingBoxQuery();
        $query->setNorthLatitude(-10.0);
        $query->setSouthLatitude(-20.0);
        $query->setEastLongitude(-30.0);
        $query->setWestLongitude(-40.0);

        $constraint = new BoundingBoxValues();

        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($query, $constraint);
    }
}
