<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\EntityFieldList;

interface EntityFieldListFactoryInterface
{
    public function createForFqcn(string $fqcn): EntityFieldList;
}
