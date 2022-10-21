<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FieldList\ParameterFieldList;

interface ParameterFieldListFactoryInterface
{
    public function createForFqcn(string $fqcn): ParameterFieldList;
}
