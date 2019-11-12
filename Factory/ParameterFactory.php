<?php declare(strict_types=1);

namespace App\Criticalmass\DataQuery\Factory;

use App\Criticalmass\DataQuery\Annotation\Sortable;
use App\Criticalmass\DataQuery\AnnotationHandler\AnnotationHandlerInterface;
use App\Criticalmass\DataQuery\Parameter\From;
use App\Criticalmass\DataQuery\Parameter\Order;
use App\Criticalmass\DataQuery\Parameter\Size;
use Symfony\Component\HttpFoundation\Request;

class ParameterFactory implements ParameterFactoryInterface
{
    /** @var string $entityFqcn */
    protected $entityFqcn;

    /** @var AnnotationHandlerInterface */
    protected $annotationHandler;

    public function __construct(AnnotationHandlerInterface $annotationHandler)
    {
        $this->annotationHandler = $annotationHandler;
    }

    public function setEntityFqcn(string $entityFqcn)
    {
        $this->entityFqcn = $entityFqcn;

        return $this;
    }

    public function createFromRequest(Request $request): array
    {
        $parameterList = [];

        if ($request->query->get('size')) {
            $size = (int)$request->query->get('size');

            $parameterList[] = new Size($size);
        }

        if ($request->query->get('from')) {
            $from = (int)$request->query->get('from');

            $parameterList[] = new From($from);
        }

        if ($request->query->get('orderBy') && $request->query->get('orderDirection')) {
            $propertyName = $request->query->get('orderBy');

            $propertyIsSortable = $this->annotationHandler->hasEntityTypedPropertyOrMethodWithAnnotation($this->entityFqcn, Sortable::class, $propertyName);

            $orderBy = (string)$request->query->get('orderBy');
            $orderDirection = (string)$request->query->get('orderDirection');

            $parameterList[] = new Order($orderBy, $orderDirection);
        }

        return $parameterList;
    }
}