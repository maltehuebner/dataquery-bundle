<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\FinderFactory;

use Maltehuebner\DataQueryBundle\Finder\FinderInterface;

interface FinderFactoryInterface
{
    public function createFinderForFqcn(string $fqcn): FinderInterface;
}
