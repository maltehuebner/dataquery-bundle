<?php declare(strict_types=1);

namespace Maltehuebner\DataQueryBundle\Manager;

use Maltehuebner\DataQueryBundle\Query\QueryInterface;

class QueryManager implements QueryManagerInterface
{
    /** @var array $queryList */
    protected $queryList = [];

    public function addQuery(QueryInterface $query): QueryManagerInterface
    {
        $this->queryList[] = $query;

        return $this;
    }

    public function getQueryList(): array
    {
        return $this->queryList;
    }
}
