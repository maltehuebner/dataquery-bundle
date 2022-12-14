<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Factory\ParamConverterFactory;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

interface ParamConverterFactoryInterface
{
    public function createParamConverter(string $fqcn): ?ParamConverterInterface;
}
