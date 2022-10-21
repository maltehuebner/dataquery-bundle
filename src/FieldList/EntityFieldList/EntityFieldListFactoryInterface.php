<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\EntityFieldList;

interface EntityFieldListFactoryInterface
{
    public function createForFqcn(string $fqcn): EntityFieldList;
}
