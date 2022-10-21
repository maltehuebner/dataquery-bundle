<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\QueryFieldList;

interface QueryFieldListFactoryInterface
{
    public function createForFqcn(string $fqcn): QueryFieldList;
}
