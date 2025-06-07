<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\EntityFieldList;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\DateTimeQueryable;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\DefaultBooleanValue;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Queryable;
use MalteHuebner\DataQueryBundle\Attribute\EntityAttribute\Sortable;
use MalteHuebner\DataQueryBundle\Exception\NoReturnTypeForEntityMethodException;

class EntityFieldListFactory implements EntityFieldListFactoryInterface
{
    private string $entityFqcn;

    private EntityFieldList $entityFieldList;

    #[\Override]
    public function createForFqcn(string $entityFqcn): EntityFieldList
    {
        $this->entityFieldList = new EntityFieldList();
        $this->entityFqcn = $entityFqcn;

        $this->addEntityPropertiesToList();
        $this->addEntityMethodsToList();

        return $this->entityFieldList;
    }

    protected function addEntityPropertiesToList(): void
    {
        $reflectionClass = new \ReflectionClass($this->entityFqcn);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            foreach ($reflectionProperty->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if ($instance instanceof AttributeInterface) {
                    $entityField = new EntityField();
                    $entityField->setPropertyName($reflectionProperty->getName());

                    $entityField = $this->processAttributes($instance, $entityField);

                    $this->entityFieldList->addField($reflectionProperty->getName(), $entityField);
                }
            }
        }
    }

    protected function addEntityMethodsToList(): void
    {
        $reflectionClass = new \ReflectionClass($this->entityFqcn);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            foreach ($reflectionMethod->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if ($instance instanceof AttributeInterface) {
                    $returnType = $reflectionMethod->getReturnType();

                    if (!$returnType) {
                        throw new NoReturnTypeForEntityMethodException($reflectionMethod->getName(), $this->entityFqcn);
                    }

                    $entityField = new EntityField();
                    $entityField
                        ->setMethodName($reflectionMethod->getName())
                        ->setType($returnType->getName());

                    $entityField = $this->processAttributes($instance, $entityField);

                    $this->entityFieldList->addField($reflectionMethod->getName(), $entityField);
                }
            }
        }
    }

    protected function processAttributes(AttributeInterface $attribute, EntityField $entityField): EntityField
    {
        if ($attribute instanceof Sortable) {
            $entityField->setSortable(true);
        }

        if ($attribute instanceof Queryable) {
            $entityField->setQueryable(true);
        }

        if ($attribute instanceof DateTimeQueryable) {
            $entityField
                ->setDateTimePattern($attribute->getPattern())
                ->setDateTimeFormat($attribute->getFormat());
        }

        if ($attribute instanceof DefaultBooleanValue) {
            $entityField
                ->setDefaultQueryBool(true)
                ->setDefaultQueryBoolValue($attribute->getValue());
        }

        return $entityField;
    }
}
