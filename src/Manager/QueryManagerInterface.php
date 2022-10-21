<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Manager;

use Maltehuebner\DataQueryBundle\Query\QueryInterface;

interface QueryManagerInterface
{
    public function addQuery(QueryInterface $query): QueryManagerInterface;

    public function getQueryList(): array;
}
