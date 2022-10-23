<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FieldList\ParameterFieldList;

interface ParameterFieldListFactoryInterface
{
    public function createForFqcn(string $fqcn): ParameterFieldList;
}
