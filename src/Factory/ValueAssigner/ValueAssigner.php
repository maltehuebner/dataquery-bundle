<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ValueAssigner;

use Doctrine\Persistence\ManagerRegistry;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use MalteHuebner\DataQueryBundle\FieldList\QueryFieldList\QueryField;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\Query\QueryInterface;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use App\Criticalmass\Util\ClassUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValueAssigner implements ValueAssignerInterface
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {

    }

    #[\Override]
    public function assignQueryPropertyValueFromRequest(RequestParameterList $requestParameterList, QueryInterface $query, QueryField $queryField): QueryInterface
    {
        if (!$requestParameterList->has($queryField->getParameterName())) {
            return $query;
        }

        $methodName = $queryField->getMethodName();
        $value = $requestParameterList->get($queryField->getParameterName());
        $type = $queryField->getType();

        switch ($type) {
            case ValueType::FLOAT:
                $query->$methodName((float)$value);
                break;

            case ValueType::INT:
                $value = $this->convertToInt($value, $queryField->getParameterName());
                $query->$methodName($value);
                break;

            case ValueType::STRING:
                $query->$methodName((string)$value);
                break;

            case ValueType::MIXED:
                $query->$methodName($value);
                break;

            default:
                $query = $this->assignEntityValueFromRepository($requestParameterList, $query, $queryField);
                break;
        }

        return $query;
    }

    #[\Override]
    public function assignParameterPropertyValueFromRequest(RequestParameterList $requestParameterList, ParameterInterface $parameter, ParameterField $parameterField): ParameterInterface
    {
        if (!$parameterField->hasParameterName() || !$requestParameterList->has($parameterField->getParameterName())) {
            return $parameter;
        }

        $methodName = $parameterField->getMethodName();
        $value = $requestParameterList->get($parameterField->getParameterName());
        $type = $parameterField->getType();

        switch ($type) {
            case ValueType::FLOAT:
                $parameter->$methodName((float)$value);
                break;

            case ValueType::INT:
                $value = $this->convertToInt($value, $parameterField->getParameterName());
                $parameter->$methodName($value);
                break;

            case ValueType::STRING:
                $parameter->$methodName((string)$value);
                break;

            case ValueType::MIXED:
                $parameter->$methodName($value);
                break;
        }

        return $parameter;
    }

    protected function assignEntityValueFromRepository(RequestParameterList $requestParameterList, QueryInterface $query, QueryField $queryField): QueryInterface
    {
        $parameterName = $queryField->getParameterName();
        $entityClass = $queryField->getType();
        $methodName = $queryField->getMethodName();

        if (!$requestParameterList->has($parameterName)) {
            return $query;
        }

        $id = $requestParameterList->get($parameterName);
        $entityManager = $this->managerRegistry->getManagerForClass($entityClass);

        if (!$entityManager) {
            throw new \RuntimeException(sprintf('No entity manager found for class %s', $entityClass));
        }

        $entity = $entityManager->getRepository($entityClass)->find($id);

        if (null === $entity) {
            return $query;
        }

        $query->$methodName($entity);

        return $query;
    }

    protected function convertToInt(string $stringValue, string $parameterName): int
    {
        if (!preg_match('/^-?\d+$/', $stringValue)) {
            throw new \InvalidArgumentException(sprintf('Parameter "%s" is not a valid integer: "%s"', $parameterName, $stringValue));
        }

        return (int)$stringValue;
    }

}
