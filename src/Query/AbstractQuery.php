<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

abstract class AbstractQuery implements QueryInterface
{
    protected string $entityFqcn;

    public function getEntityFqcn(): string
    {
        return $this->entityFqcn;
    }

    public function setEntityFqcn(string $entityFqcn): AbstractQuery
    {
        $this->entityFqcn = $entityFqcn;

        return $this;
    }

    #[\Override]
    public function isOverridenBy(): array
    {
        return [];
    }
}
