<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ParameterFactory;

use MalteHuebner\DataQueryBundle\Factory\ValueAssigner\ValueAssignerInterface;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterField;
use MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList\ParameterFieldListFactoryInterface;
use MalteHuebner\DataQueryBundle\Manager\ParameterManagerInterface;
use MalteHuebner\DataQueryBundle\Parameter\ParameterInterface;
use MalteHuebner\DataQueryBundle\RequestParameterList\RequestParameterList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParameterFactory implements ParameterFactoryInterface
{
    protected string $entityFqcn;

    public function __construct(
        private readonly ParameterManagerInterface $parameterManager,
        private readonly ValueAssignerInterface $valueAssigner,
        private readonly ValidatorInterface $validator,
        private readonly ParameterFieldListFactoryInterface $parameterFieldListFactory
    ) {

    }

    #[\Override]
    public function setEntityFqcn(string $entityFqcn): ParameterFactoryInterface
    {
        $this->entityFqcn = $entityFqcn;

        return $this;
    }

    #[\Override]
    public function createFromList(RequestParameterList $requestParameterList): array
    {
        $parameterList = [];

        /** @var ParameterInterface $parameter */
        foreach ($this->parameterManager->getParameterList() as $parameterCandidate) {
            $parameter = $this->checkForParameter($parameterCandidate::class, $requestParameterList);

            if ($parameter) {
                $parameterList[] = $parameter;
            }
        }

        return $parameterList;
    }

    protected function checkForParameter(string $queryFqcn, RequestParameterList $requestParameterList): ?ParameterInterface
    {
        $parameterFieldList = $this->parameterListFactory->createForFqcn($queryFqcn);

        /** @var ParameterInterface $parameter */
        $parameter = new $queryFqcn();
        $parameter->setEntityFqcn($this->entityFqcn);
        
        /** @var ParameterField $parameterField */
        foreach ($parameterFieldList->getList() as $fieldName => $parameterFields) {
            foreach ($parameterFields as $parameterField) {
                $parameter = $this->valueAssigner->assignParameterPropertyValueFromRequest($requestParameterList, $parameter, $parameterField);
            }
        }

        if (!$this->isParameterValid($parameter)) {
            return null;
        }
        
        return $parameter;
    }

    protected function isParameterValid(ParameterInterface $parameter): bool
    {
        $constraintViolationList = $this->validator->validate($parameter);

        return $constraintViolationList->count() === 0;
    }
}
