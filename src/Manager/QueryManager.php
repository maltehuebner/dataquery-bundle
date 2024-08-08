<?php declare(strict_types=1);

namespace MalteHuebner\DataQueryBundle\Manager;

use MalteHuebner\DataQueryBundle\Query\QueryInterface;

class QueryManager implements QueryManagerInterface
{
    /** @var array $queryList */
    protected $queryList = [];

    #[\Override]
    public function addQuery(QueryInterface $query): QueryManagerInterface
    {
        $this->queryList[] = $query;

        return $this;
    }

    #[\Override]
    public function getQueryList(): array
    {
        return $this->queryList;
    }
}
