<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Parameter;

abstract class AbstractParameter implements ParameterInterface
{
    protected string $entityFqcn;

    #[\Override]
    public function setEntityFqcn(string $entityFqcn): ParameterInterface
    {
        $this->entityFqcn = $entityFqcn;

        return $this;
    }

    #[\Override]
    public function getEntityFqcn(): string
    {
        return $this->entityFqcn;
    }
}
