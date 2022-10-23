<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\QueryFieldList;

interface QueryFieldListFactoryInterface
{
    public function createForFqcn(string $fqcn): QueryFieldList;
}
