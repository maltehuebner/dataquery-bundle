<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\FinderFactory;

use MalteHuebner\DataQueryBundle\Finder\FinderInterface;

interface FinderFactoryInterface
{
    public function createFinderForFqcn(string $fqcn): FinderInterface;
}
