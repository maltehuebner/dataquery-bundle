<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\QueryFieldList;

use MalteHuebner\DataQueryBundle\Attribute\QueryAttribute\RequiredQueryParameter;
use MalteHuebner\DataQueryBundle\Exception\NotOneParameterForRequiredMethodException;
use MalteHuebner\DataQueryBundle\Exception\NoTypedParameterForRequiredMethodException;

class QueryFieldListFactory implements QueryFieldListFactoryInterface
{
    protected string $queryFqcn;

    protected QueryFieldList $queryFieldList;

    #[\Override]
    public function createForFqcn(string $queryFqcn): QueryFieldList
    {
        $this->queryFieldList = new QueryFieldList();
        $this->queryFqcn = $queryFqcn;

        $this->addQueryPropertiesToList();
        $this->addQueryMethodsToList();

        return $this->queryFieldList;
    }

    protected function addQueryPropertiesToList(): void
    {
        $reflectionClass = new \ReflectionClass($this->queryFqcn);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            foreach ($reflectionProperty->getAttributes(RequiredQueryParameter::class) as $attribute) {
                $instance = $attribute->newInstance();

                $queryField = new QueryField();
                $queryField
                    ->setPropertyName($reflectionProperty->getName())
                    ->setParameterName($instance->getParameterName());

                // Optional: Typ holen (ab PHP 7.4+ möglich)
                $type = $reflectionProperty->getType();
                if ($type) {
                    $queryField->setType($type->getName());
                }

                $this->queryFieldList->addField($reflectionProperty->getName(), $queryField);
            }
        }
    }

    protected function addQueryMethodsToList(): void
    {
        $reflectionClass = new \ReflectionClass($this->queryFqcn);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            foreach ($reflectionMethod->getAttributes(RequiredQueryParameter::class) as $attribute) {
                $instance = $attribute->newInstance();

                if ($reflectionMethod->getNumberOfParameters() !== 1) {
                    throw new NotOneParameterForRequiredMethodException($reflectionMethod->getName(), $this->queryFqcn);
                }

                $methodParameter = $reflectionMethod->getParameters()[0];
                $reflectionType = $methodParameter->getType();

                if (!$reflectionType) {
                    throw new NoTypedParameterForRequiredMethodException($reflectionMethod->getName(), $this->queryFqcn);
                }

                $queryField = new QueryField();
                $queryField
                    ->setMethodName($reflectionMethod->getName())
                    ->setParameterName($instance->getParameterName())
                    ->setType($reflectionType->getName());

                $this->queryFieldList->addField($reflectionMethod->getName(), $queryField);
            }
        }
    }
}
