<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList;

use MalteHuebner\DataQueryBundle\Attribute\AttributeInterface;
use MalteHuebner\DataQueryBundle\Attribute\ParameterAttribute\RequiredParameter;
use MalteHuebner\DataQueryBundle\Exception\NotOneParameterForRequiredMethodException;

class ParameterFieldListFactory implements ParameterFieldListFactoryInterface
{
    private string $parameterFqcn;

    protected ParameterFieldList $parameterFieldList;

    #[\Override]
    public function createForFqcn(string $parameterFqcn): ParameterFieldList
    {
        $this->parameterFieldList = new ParameterFieldList();
        $this->parameterFqcn = $parameterFqcn;

        $this->addParameterPropertiesToList();
        $this->addParameterMethodsToList();

        return $this->parameterFieldList;
    }

    protected function addParameterPropertiesToList(): void
    {
        $reflectionClass = new \ReflectionClass($this->parameterFqcn);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            foreach ($reflectionProperty->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if ($instance instanceof AttributeInterface) {
                    $parameterField = new ParameterField();
                    $parameterField->setPropertyName($reflectionProperty->getName());

                    if ($instance instanceof RequiredParameter) {
                        $parameterField->setParameterName($instance->getParameterName());
                    }

                    $this->parameterFieldList->addField($reflectionProperty->getName(), $parameterField);
                }
            }
        }
    }

    protected function addParameterMethodsToList(): void
    {
        $reflectionClass = new \ReflectionClass($this->parameterFqcn);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            foreach ($reflectionMethod->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if ($instance instanceof AttributeInterface) {

                    if ($reflectionMethod->getNumberOfParameters() !== 1) {
                        throw new NotOneParameterForRequiredMethodException($reflectionMethod->getName(), $this->parameterFqcn);
                    }

                    $parameterField = new ParameterField();
                    $parameterField->setMethodName($reflectionMethod->getName());

                    $methodParameter = $reflectionMethod->getParameters()[0];
                    $reflectionType = $methodParameter->getType();

                    $parameterField->setType($reflectionType?->getName() ?? 'mixed');

                    if ($instance instanceof RequiredParameter) {
                        $parameterField->setParameterName($instance->getParameterName());
                    }

                    $this->parameterFieldList->addField($reflectionMethod->getName(), $parameterField);
                }
            }
        }
    }
}
