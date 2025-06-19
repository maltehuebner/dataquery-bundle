<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Query;

interface QueryInterface
{
    public function getEntityFqcn(): string;
    public function setEntityFqcn(string $entityFqcn): AbstractQuery;
    public function isOverridenBy(): array;
}
