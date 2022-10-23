<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Manager;

use MalteHuebner\DataQueryBundle\Query\QueryInterface;

interface QueryManagerInterface
{
    public function addQuery(QueryInterface $query): QueryManagerInterface;

    public function getQueryList(): array;
}
