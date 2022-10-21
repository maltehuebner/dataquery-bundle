<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Finder;

interface FinderInterface
{
    public function executeQuery(array $queryList, array $parameterList): array;
}
